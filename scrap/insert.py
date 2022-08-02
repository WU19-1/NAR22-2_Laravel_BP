from typing import final
import mysql.connector

con = mysql.connector.connect(host="localhost", database="elibookstore", user="root", password="")
if con.is_connected():
    q_file = open("result.sql", "r")
    qs = q_file.readlines()
    q_file.close()
    for q in qs:
        try:
            # print(q.rstrip())
            cur = con.cursor()
            cur.execute("{}".format(q))
        except Exception as e:
            print(e)
            continue
        # finally:
        #     input()
    con.commit()
    con.close()
else:
    print("Connection failed!")