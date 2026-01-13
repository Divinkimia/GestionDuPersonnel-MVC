# Instructions de Migration

## Problème rencontré

L'erreur "Colonne inconnue « sce_actif »" indique que votre base de données utilise encore l'ancienne structure (sans les nouvelles colonnes).

## Solution : Exécuter le script de migration

### Option 1 : Migration simple (RECOMMANDÉE)

1. **Ouvrir phpMyAdmin** : `http://localhost/phpmyadmin`

2. **Sélectionner votre base de données** (`empsceMvc` ou `empsce`)

3. **Onglet SQL** : Cliquer sur l'onglet "SQL" en haut

4. **Copier le contenu** du fichier `migration_simple.sql` et le coller dans la zone de texte

5. **Exécuter** : Cliquer sur "Exécuter"

### Option 2 : Migration via ligne de commande

Si vous préférez utiliser la ligne de commande MySQL :

```bash
mysql -u root -p empsceMvc < migration_simple.sql
```

(Remplacez `empsceMvc` par le nom de votre base de données)

## Vérification

Après avoir exécuté le script, vérifiez que les colonnes ont été ajoutées :

```sql
DESCRIBE service;
DESCRIBE employe;
```

Vous devriez voir les nouvelles colonnes :
- Dans `service` : `sce_actif`
- Dans `employe` : `emp_email`, `emp_telephone`, `emp_poste`, `emp_date_embauche`, `emp_salaire`, `emp_actif`

## Si vous avez des erreurs

Si vous obtenez l'erreur "Duplicate column name", cela signifie que certaines colonnes existent déjà. Dans ce cas :

1. Exécutez seulement les commandes ALTER TABLE qui n'ont pas encore été exécutées
2. Ou supprimez les lignes correspondantes du script avant de l'exécuter

## Note

Le code a été modifié pour être plus tolérant, mais il est **fortement recommandé** d'exécuter le script de migration pour avoir toutes les fonctionnalités.
