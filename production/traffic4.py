
import mysql.connector
import os

os.system("vnstat -d -i enp0s3 > daily.txt")
fichier = open("daily.txt", "r")
for i in range(6):
    lalignesuivante = fichier.readline()
print lalignesuivante
traffic = ""
traffic = lalignesuivante
print traffic
tapaka = traffic.split('  ',5)
date = tapaka[2]
donnerestant = tapaka[4].split('|',2)
donnerestant[0].strip()
print donnerestant[0]
donnerestant2 = tapaka[5].split('|',3)
for i in range(4):
    donnerestant2[i].strip()
    print donnerestant2[i]
request = "INSERT INTO traffic(date,download,upload,total,debit) VALUES ('" + date + "','" + donnerestant2[0] + "','" + donnerestant2[1] + "','" + donnerestant2[2] +"','" +donnerestant2[3]+ "')"
print request
conn = mysql.connector.connect(user='root', password='virtuel', host='localhost', database='datamap')
curseur = conn.cursor()
curseur.execute(request)
conn.commit()
