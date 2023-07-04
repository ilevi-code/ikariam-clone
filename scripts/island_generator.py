import json
import mariadb
import random

def randomize_island_shape():
    return random.randint(1,5)

def randomize_wonder():
    return random.randint(1,8)

def main():
    connection = mariadb.connect(host='localhost',user='root',password='',database='ik_game', unix_socket='mysql/mysql.sock')
    cursor = connection.cursor()

    with open('scripts/islands.json') as island_file:
        islands = json.load(island_file)

    for i, row in enumerate(islands):
        for j, island in enumerate(row):
            if not island:
                continue
            id, resource, name = island
            cursor.execute("INSERT INTO alpha_islands (id,trade_resource,name,x,y,type,wonder) VALUES (?, ?, ?, ?, ?, ?, ?)", 
                (id, resource, name, i, j, randomize_island_shape(), randomize_wonder()))
    
    connection.close()

if __name__ == '__main__':
    main()
