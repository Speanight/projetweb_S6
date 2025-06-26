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

for i in data.iloc:
   mmsi = str(i['MMSI'])
   datetime = str(i['BaseDateTime'])
   lat = str(i['LAT'])
   lon = str(i['LON'])
   sog = str(i['SOG'])
   cog = str(i['COG'])
   heading = str(i['Heading'])
   vesselname = str(i['VesselName'])
   imo = str(i['IMO'])[4:]
   vesseltype = str(i['VesselType'])[:1] + '0'
   status = str(i['Status'])
   length = str(i['Length'])
   width = str(i['Width'])
   draft = str(i['Draft'])
   cluster = 0

   cursor.execute('''INSERT INTO ship (mmsi, vesselname, imo, length, width, draft, type, num_cluster)
                     VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
                     ON CONFLICT (mmsi) DO NOTHING''', (mmsi, vesselname, imo, length, width, draft, vesseltype, cluster))

   cursor.execute('''INSERT INTO position (lat, lon, timestamp, sog, cog, heading, status, mmsi)
                     VALUES (%s, %s, %s, %s, %s, %s, %s, %s)''', (lat, lon, datetime, sog, cog, heading, status, mmsi));

conn.commit()
conn.close()
print("Records inserted........")