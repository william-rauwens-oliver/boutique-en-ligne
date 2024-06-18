const express = require('express');
const bodyParser = require('body-parser');
const bcrypt = require('bcrypt');
const cors = require('cors');
const db = require('./Database');

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

  db.query('INSERT INTO users (username, password) VALUES (?, ?)', [username, hashedPassword], (err, results) => {
    if (err) {
      return res.status(500).json({ error: 'User already exists or other error' });
    }
    res.status(200).json({ message: 'User registered successfully' });
  });
});

// Endpoint pour la connexion
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  db.query('SELECT * FROM users WHERE username = ?', [username], (err, results) => {
    if (err || results.length === 0 || !bcrypt.compareSync(password, results[0].password)) {
      return res.status(400).json({ error: 'Invalid credentials' });
    }
    res.status(200).json({ message: 'Login successful' });
  });
});

// Démarrage du serveur sur le port 3000
app.listen(3000, () => {
  console.log('Server is running on port 3000');
});
