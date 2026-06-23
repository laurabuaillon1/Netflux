# ============================================
# Stage de build : Compilation de l'application
# ============================================
FROM node:20-alpine AS build

WORKDIR /app

# Installation des dépendances (utilise le cache Docker si package.json n'a pas changé)
COPY frontend/package*.json ./
RUN npm ci

# Copie du code source et build de production
COPY frontend/ .
RUN npm run build

# ============================================
# Stage production : Serveur Nginx
# ============================================
FROM nginx:alpine AS prod

# Copie des fichiers buildés
COPY --from=build /app/dist /usr/share/nginx/html

# La configuration Nginx sera montée via docker-compose

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

# ============================================
# Stage développement : Serveur Vite
# ============================================
FROM node:20-alpine AS dev

WORKDIR /app

# Installation des dépendances
COPY frontend/package*.json ./
RUN npm install

# Copie du code source
COPY frontend/ .

EXPOSE 5173

# --host 0.0.0.0 : permet l'accès depuis l'extérieur du conteneur
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]