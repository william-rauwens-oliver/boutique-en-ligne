const express = require('express');
const bodyParser = require('body-parser');
const bcrypt = require('bcrypt');
const cors = require('cors');
const db = require('./Database'); // Assurez-vous que le chemin vers votre configuration de base de données est correct

const app = express();

// Middleware pour autoriser CORS
const corsOptions = {
  origin: 'http://127.0.0.1:5500',  // Autorise l'origine spécifiée
  credentials: true, // Autorise l'envoi de cookies
};

app.use(cors(corsOptions));

// Middleware pour parser le JSON
app.use(bodyParser.json());

// Endpoint pour l'inscription
app.post('/register', (req, res) => {
  const { username, password } = req.body;
  const hashedPassword = bcrypt.hashSync(password, 10);

  console.log('Requête d\'inscription reçue pour :', username);

  // Insérer l'utilisateur dans la base de données
  db.query('INSERT INTO users (username, password) VALUES (?, ?)', [username, hashedPassword], (err, results) => {
    if (err) {
      console.error('Erreur lors de l\'insertion de l\'utilisateur :', err);
      return res.status(500).json({ error: 'Erreur interne du serveur' });
    }
    console.log('Utilisateur inséré avec succès dans la base de données');
    res.status(200).json({ message: 'Utilisateur inscrit avec succès' });

    // Redirection vers Boutique.html après inscription réussie
    res.redirect('/Boutique.html');
  });
});

// Endpoint pour la connexion
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  // Recherche de l'utilisateur dans la base de données
  db.query('SELECT * FROM users WHERE username = ?', [username], (err, results) => {
    if (err || results.length === 0 || !bcrypt.compareSync(password, results[0].password)) {
      console.error('Erreur de connexion : identifiants invalides');
      return res.status(400).json({ error: 'Identifiants invalides' });
    }
    console.log('Connexion réussie pour l\'utilisateur :', username);
    res.status(200).json({ message: 'Connexion réussie' });

    // Redirection vers Boutique.html après connexion réussie
    res.redirect('/Boutique.html');
  });
});

// Démarrage du serveur sur le port 3000
app.listen(3000, () => {
  console.log('Le serveur fonctionne sur le port 3000');
});
