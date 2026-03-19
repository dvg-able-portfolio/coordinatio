# Day 1 – Symfony Realtime Products Project

**Date:** 2026-03-16  

### Goals
- Set up a new Symfony web application with real-time product updates using Mercure.
- Establish a clean Docker-based development environment.

### Steps Taken

1. **Project Initialization**
   - Created a new Symfony project: `symfony-realtime-products`.  
   - Initialized the project using the Symfony binary with the `--webapp` option.  

2. **Project Organization**
   - Created folders for Docker configuration and project documentation.  
   - Designed a basic `docker-compose.yaml` and `Dockerfile` setup for:
     - `symfony-app` (PHP + Symfony)
     - `caddy` (reverse proxy & local development server)  

3. **Configuration Adjustments**
   - Edited the `Caddyfile`, `Dockerfile`, and `docker-compose.yaml` to ensure proper networking and service connections.  
   - Configured volumes, cache/log directories, and environment variables for dev mode.  

4. **Feature Implementation – Mercure**
   - Created a **test view** to render pages.  
   - Created a **trigger view** to publish and subscribe to Mercure messages.  
   - Verified that publishing/subscribing worked correctly from the browser and AJAX requests.  

5. **Performance Issues & Debugging**
   - Observed slow page load times (~1.5 s per request) even with container-local cache and warmed cache.  
   - Investigated Symfony dev-mode cache validation, AJAX request timing, and host filesystem performance.  

6. **Resolution**
   - Switched development to **WSL Ubuntu** on Windows.  
   - Configured VSCode to use **WSL Remote Server**.  
   - After the switch, page loads and AJAX requests became consistently fast (~0.3–0.5 s), confirming host FS performance was the main bottleneck.  

### Lessons Learned
- Symfony dev mode is highly sensitive to **filesystem performance**, especially with host-mounted volumes.  
- Container-local cache and logs are essential for fast development iterations.  
- WSL2 / Linux-native filesystem dramatically improves Docker + Symfony performance on Windows.  
- Initial setup takes time, but once the environment is correctly configured, further development becomes smooth and efficient.  