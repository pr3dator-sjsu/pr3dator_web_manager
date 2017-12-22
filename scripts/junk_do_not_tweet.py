#!/usr/bin/python
#import sqlite3
#conn = sqlite3.connect('classicmodels.db')
#c = conn.cursor()
#c.execute("SELECT api_name FROM classicmodels.api_information WHERE api_id=1;")
#cur.execute("SELECT api_name,api_uri,api_key FROM classicmodels.api_information where api_id=2")
#cur.fetchone()
# Fetch a single row using fetchone() method and store the result in a variable.
data = cur.fetchone()
# print all the first cell of all the rows


'''
for row in cur.fetchall()
