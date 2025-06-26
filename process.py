import sys
import pickle
import pandas as pd
import json

contextPath = "/var/www/projetweb_S6/"

# Fonctionnalite 1 - Trouver le cluster associé.
def cluster(raw_data):
    # On met les données dans un DataFrame
    data = raw_data[['LON', 'LAT', 'SOG']]

    # Puis on passe le tout par le modèle.
    model_file = contextPath + 'assets/pkl/cluster.pkl'
    with open(model_file, 'rb') as file:
        model = pickle.load(file)
    return model.predict(data)


# Fonctionnalite 2 - Trouver le type du navire.
def type_navire(raw_data):
    # On met les données dans un DataFrame
    data = raw_data[['Length', 'Width', 'Draft']]

    # Puis on passe le tout par le modèle.
    model_file = contextPath + 'assets/pkl/typeNavire.pkl'
    with open(model_file, 'rb') as file:
        model = pickle.load(file)
    return model.predict(data)


# Fonctionnalite 3 - Trouver la trajectoire d'un navire
def traj_navire(raw_data):
    # On met les données dans un DataFrame
    data = raw_data[["SOG", "COG", "Heading", "VesselType", "delta_sec"]]

    # Puis on passe le tout par le modèle.
    model_file = contextPath + 'assets/pkl/trajNavire.pkl'
    with open(model_file, 'rb') as file:
        model = pickle.load(file)
    return model.predict(data)


# Exécution du code si appelé directement.
if __name__ == '__main__':
    # Récupération des arguments
    model = sys.argv[1]
    data_file = contextPath + sys.argv[2]
    ret = sys.argv[3]

    # Ouverture du fichier .json
    with open(data_file, 'r') as f:
        data = json.load(f)

    # Récupération des données en lien avec le bateau
    boat_data = pd.DataFrame()
    j = 0
    for i in data['bateau']:
        boat_data.insert(j, i, [data['bateau'][i]])
        j += 1


    # Switch-case selon la fonction souhaitée
    match model:
        case 'typeNavire':
            data['result'] = type_navire(boat_data).tolist()
            data['result'][0] = data['result'][0] * 10 + 60
            # On indique que l'on a obtenu un résultat
            data['scriptStatus'] = 0
        case 'Cluster':
            data['result'] = cluster(boat_data).tolist()
            # On indique que l'on a obtenu un résultat
            data['scriptStatus'] = 0
        case 'trajNavire':
            data['result'] = traj_navire(boat_data).tolist()
            # On indique que l'on a obtenu un résultat
            data['scriptStatus'] = 0
        case _: # Si aucun des modèles renseignés
            data['result'] = "Erreur : modele non reconnu !"
            data['scriptStatus'] = -1

    # On remplace le fichier json par les nouvelles valeurs.
    with open(data_file, 'w') as f:
        json.dump(data, f, ensure_ascii=False, indent=4)
    
    if ret == '1':
        print(json.dumps(data))
