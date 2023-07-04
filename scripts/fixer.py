from os import getuid
import re
import click
import json

@click.group()
def cli():
    pass


def get_russian(filename):
    with open(filename) as f:
        text = f.read()
        words = re.findall('(?:[а-яА-Я]+[- .,]*)+', text)
    words = list(set(words))
    words.sort(key=lambda s: len(s), reverse=True)
    return words

@cli.command()
@click.argument("filename", default="./application/views/view/townHall.php")
def ls(filename):
    print(get_russian(filename))

@cli.command()
@click.argument("filename", default="./application/views/view/townHall.php")
def trans(filename):
    with open('dict.json', 'r') as trans:
        d = json.load(trans)
    for word in get_russian(filename):
        print(word, "=>", d[word])

@cli.command()
@click.argument("key")
@click.argument("value")
def fix(key, value):
    with open('dict.json', 'r') as trans:
        d = json.load(trans)
    d[key] = value
    with open('dict.json', 'w') as dict_file:
        json.dump(d, dict_file)

cli()