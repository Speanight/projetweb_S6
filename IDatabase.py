import psycopg2
import pandas as pd

data = pd.read_csv('assets/vessel-total-nettoye.csv', index_col=0)

#Establishing the connection
conn = psycopg2.connect(
   database="titanisen", user='postgres', password='Isen44N', host='127.0.0.1', port= '5432'
)

#Setting auto commit false
conn.autocommit = True

#Creating a cursor object using the cursor() method
cursor = conn.cursor()

for i in raw_data.iloc:
  print(i)
  mmsi = str(i['MMSI'])
  datetime = str(i['BaseDateTime'])
  lat = str(i['LAT'])
  lon = str(i['LON'])
  sog = str(i['SOG'])
  cog = str(i['COG'])
  heading = str(i['Heading'])
  vesselname = str(i['VesselName'])
  imo = str(i['IMO'])
  vesseltype = str(i['VesselType'])
  status = str(i['Status'])
  length = str(i['Length'])
  width = str(i['Width'])
  draft = str(i['Draft'])

  cursor.execute('''INSERT INTO ship (mmsi, vesselname, imo, length, width, draft, type, num_cluster)
                    VALUES (${mmsi}, ${vesselname}, ${imo}, ${length}, ${width}, ${draft}, ${vesseltype}, ${})''')

conn.commit()
conn.close()


# Preparing SQL queries to INSERT a record into the database.
cursor.execute('''INSERT INTO EMPLOYEE(FIRST_NAME, LAST_NAME, AGE, SEX,
   INCOME) VALUES ('Ramya', 'Rama priya', 27, 'F', 9000)''')
cursor.execute('''INSERT INTO EMPLOYEE(FIRST_NAME, LAST_NAME, AGE, SEX,
   INCOME) VALUES ('Vinay', 'Battacharya', 20, 'M', 6000)''')
cursor.execute('''INSERT INTO EMPLOYEE(FIRST_NAME, LAST_NAME, AGE, SEX,
   INCOME) VALUES ('Sharukh', 'Sheik', 25, 'M', 8300)''')
cursor.execute('''INSERT INTO EMPLOYEE(FIRST_NAME, LAST_NAME, AGE, SEX,
   INCOME) VALUES ('Sarmista', 'Sharma', 26, 'F', 10000)''')
cursor.execute('''INSERT INTO EMPLOYEE(FIRST_NAME, LAST_NAME, AGE, SEX,
   INCOME) VALUES ('Tripthi', 'Mishra', 24, 'F', 6000)''')

# Commit your changes in the database
conn.commit()
print("Records inserted........")

# Closing the connection
conn.close()