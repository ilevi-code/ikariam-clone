import re
import json
import pexpect
import hashlib
import glob
from tqdm import tqdm

class Translator:
    def __init__(self) -> None:
        self.proc = pexpect.spawn("gawk -f translate -- -brief -no-auto")
        self.words = self._load()
    
    def _load(self):
        with open('dict.json', 'r') as trans:
            return json.load(trans)
    
    def translate(self, word: str):
        translated = self.words.get(word)
        if translated:
            return translated
        translated = self._translate(word)
        self._update(word, translated)
        return translated
    
    def _translate(self, word: str):
        # print(f"translating {word} ", end='', flush=True)
        self.proc.sendline(word)
        self.proc.readline()
        translated = self.proc.readline().decode()[:-2]
        # print(f"=> {translated}")
        return translated
    
    def _update(self, word, translated):
        self.words[word] = translated
        with open('dict.json', 'w') as dict_file:
            json.dump(self.words, dict_file)
    

def get_russian(text):
    # words = re.findall('[а-яА-Я]+', text)
    words = re.findall('(?:[а-яА-Я]+[- .,]*)+', text)
    words = list(set(words))
    words.sort(key=lambda s: len(s), reverse=True)
    return words

def md5(text: str) -> bytes:
    return hashlib.md5(text.encode()).digest()

translator = Translator()

def fix(file):
    with open(file) as f:
        text = f.read()
    words = get_russian(text)
    if not words:
        return

    missing = len([word for word in words if word not in translator.words])
    print(f"Found {len(words)} words to translate, need to translate {missing} words")
    for word in tqdm(words):
        translated = translator.translate(word)
        text = text.replace(word, translated)

    with open(file, 'w')  as f:
        f.write(text)


def main():
    # dir = "../application/views/sidebox/"
    dir = "../application/views/tut/"
    # dir = "../application/views/view/"
    files = glob.glob(dir +"*.php")
    for i, file in enumerate(files):
        print(f"fixing {file} ({i}/{len(files)})")
        fix(file)

if __name__ == "__main__":
    main()