# Project Decisions – Symfony Realtime Products

### 1. Docker Setup
- Initially considered using [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker) for the Docker setup.  
- Decided to build the Docker environment from scratch to **learn more about Docker and Symfony integration** and to have **full control** over the configuration.

### 2. Mercure Hub
- Chose to run **Mercure as a separate Docker service** rather than embedding it directly in the Caddyfile.  
- This approach simplifies networking, makes it reusable across services, and avoids conflicts with Caddy configuration.

### 3. Symfony Project Initialization
- Used the **Symfony binary** to create the project.  
- Initialized the project with the `--webapp` option to get a **modern web application skeleton** with preconfigured best practices.  
- This ensured a **good starting point** while keeping the project structure clean and ready for real-time Mercure integration.