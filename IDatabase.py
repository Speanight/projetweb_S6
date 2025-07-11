import psycopg2
import pandas as pd

print("Lecture du fichier csv...")
data = pd.read_csv('assets/vessel-total-nettoye.csv', index_col=0)

print("Connexion à la base de données...")
#Establishing the connection
conn = psycopg2.connect(
   database="titanisen", user='postgres', password='Isen44N', host='127.0.0.1', port= '5432'
)

#Setting auto commit false
conn.autocommit = True

#Creating a cursor object using the cursor() method
cursor = conn.cursor()

print("Ajout des données...")
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (0, 'Cluster zero') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (1, 'Cluster one') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (2, 'Cluster two') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (3, 'Cluster three') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (4, 'Cluster four') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (5, 'Cluster five') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (6, 'Cluster six') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (7, 'Cluster seven') ON CONFLICT(num_cluster) DO NOTHING''')
cursor.execute('''INSERT INTO cluster (num_cluster, description) VALUES (8, 'Unclustered') ON CONFLICT(num_cluster) DO NOTHING''')

cursor.execute('''INSERT INTO vesseltype (type, description) VALUES (60, 'Passenger') ON CONFLICT (type) DO NOTHING''')
cursor.execute('''INSERT INTO vesseltype (type, description) VALUES (70, 'Cargo') ON CONFLICT (type) DO NOTHING''')
cursor.execute('''INSERT INTO vesseltype (type, description) VALUES (80, 'Tanker') ON CONFLICT (type) DO NOTHING''')

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
   cluster = 8

   cursor.execute('''INSERT INTO ship (mmsi, vesselname, imo, length, width, draft, type, num_cluster)
                     VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
                     ON CONFLICT (mmsi) DO NOTHING''', (mmsi, vesselname, imo, length, width, draft, vesseltype, cluster))

   cursor.execute('''INSERT INTO position (lat, lon, timestamp, sog, cog, heading, status, mmsi)
                     VALUES (%s, %s, %s, %s, %s, %s, %s, %s)''', (lat, lon, datetime, sog, cog, heading, status, mmsi))

print("Commit des changements...")
conn.commit()
conn.close()
print("Exécution terminée !")