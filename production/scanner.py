import nmap
import mysql.connector
from datetime import datetime
from ares import CVESearch
nm = nmap.PortScanner()
nm.scan('192.168.8.0/24','0-1024')
print nm.command_line()
print nm.all_hosts()
temp = datetime.now()
print nm.csv()


for host in nm.all_hosts():
    print host,nm[host].state()
    for proto in nm[host].all_protocols():
        print proto
        lport = nm[host][proto].keys()
        lport.sort()
        print lport
        b = ""
        name= ""
        portstate= ""
        productconca = ""
        cpeconc= ""
        for a in lport:
            b = str(b) + ',' + str(a)
            print nm[host][proto][a]['state'],nm[host][proto][a]['name']
            name = str(name)+ ',' + str(nm[host][proto][a]['name'])
            portstate = str(portstate) + ',' + str(nm[host][proto][a]['state'])
            productconca = str(productconca) + ',' + str(nm[host][proto][a]['product'])
            cpeconc= str(cpeconc) + ',' + str(nm[host][proto][a]['cpe'])
        print cpeconc
        form = b.split(',', 1)
        serv = name.split(',', 1)
        stat = portstate.split(',',1)
        prod = productconca.split(',',1)
        cpe = cpeconc.split(',',1)
        request = "INSERT INTO data(time,address,state,port,service,portstat,product,cpe) VALUES ('" + temp.strftime('%Y/%m/%d %H:%M:%S') + "','" + str(host) + "','" + nm[host].state() + "','" + form[1] + "','" + serv[1] + "','" + stat[1] + "','" +prod[1]+ "','" +cpe[1]+"')"
        print request
        conn = mysql.connector.connect(user='root', password='virtuel', host='localhost', database='datamap')
        curseur = conn.cursor()
        curseur.execute(request)
        conn.commit()
	cve = CVESearch()
	print  cve.cvefor(cpe)
	print request

