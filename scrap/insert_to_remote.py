from typing import final
import mysql.connector

con = mysql.connector.connect(host="containers-us-west-25.railway.app", database="railway", user="root", password="mz5WVJLJvs2Eey80jgjZ", port='7077', auth_plugin='mysql_native_password')
if con.is_connected():
    q_file = open("books.csv", "r")
    qs = q_file.readlines()
    q_file.close()
    for q in qs:
        try:
            # print(q.rstrip())
            info = q.split(",")
            cur = con.cursor()
            # print("INSERT into books VALUES (null, '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}' )".format(info[1],info[2],info[3],info[4],info[5],info[6],info[7],info[8],info[9],info[10]))
            cur.execute("INSERT INTO `books` VALUES (null, '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}')".format(info[1],info[2],info[3],info[4],info[5],info[6],info[7],info[8],info[9],info[10]))
        except Exception as e:
            print(e)
        # finally:
        #     input()
    try:
        cur.execute("UPDATE books SET publication_date = CURRENT_DATE - INTERVAL FLOOR(RAND() * 36500) DAY;")
    except Exception:
        pass
    con.commit()
    con.close()
else:
    print("Connection failed!")
