# Day 1 – Symfony Coordinatio Project

**Date:** 2026-03-16

### Goals

- Set up a Symfony web app with real-time updates using Mercure.
- Establish a Docker-based development environment.

### Steps Taken

1. **Project Organization**
    - Added Docker config and docs folders.
    - Set up `docker-compose.yaml` and `Dockerfile` for:
        - `app` (PHP + Symfony)
        - `caddy` (reverse proxy & dev server)
2. **Project Initialization**
    - Created Symfony project `coordinatio` using `--webapp`.
3. **Configuration**
    - Adjusted volumes, cache/log directories, env variables, and networking.
4. **Mercure Feature (Tests)**
    - Created test and trigger views for publishing/subscribing messages.
    - Verified functionality in browser and via AJAX.
5. **Performance & Debugging**
    - Page load ~1.5 s in Windows host.
    - Bottleneck traced to host filesystem.
6. **Resolution**
    - Switched to **WSL Ubuntu** + VSCode Remote.
    - Page loads improved to ~0.3–0.5 s.

### Lessons Learned

- Dev mode sensitive to filesystem performance.
- Container-local cache/logs essential.
- WSL2 / Linux FS dramatically improves Docker + Symfony on Windows.
- Proper initial setup simplifies further development.

---

# Day 2 – Entities, CRUD & Templates

**Date:** 2026-03-18

### Steps Taken

- Created basic **Entities** with `make:entity`.
- Generated `/crud` pages via `make:crud`.
- Implemented **base template** with partials (header, footer, flash).
- Chose **Bootstrap** over Tailwind for faster development.
- Removed old controllers/views from Mercure Test setup.
- Cleaned boilerplate code.
- Installed VSCode extensions: Twig Language 2, Prettier.
- Implemented **translations** (`de`, `en`) and a language switch (`LocaleSubscriber`).
- Created `App\Provider\HeaderMenuProvider` for menu config from `menus.yaml`.

### Lessons Learned

- `make:*` commands help understand project structure and speed up development.

---

# Day 3 – Translation Tools & Home Page

**Date:** 2026-03-19

### Steps Taken

- Added `/dev` `CrudEntityTranslationsController` for faster translation updates.
- Implemented full translations in all `/crud` views.
- Refactored `/crud` template code into macros for centralized redesign.
- Added `/home` view with a logo and short description.
- Added docs under `docs/`: about-me, decisions, development-log, project-overview.
- Made initial commit and several small commits for tracking changes.

### Lessons Learned

- Growing familiarity with VSCode after years on PHPStorm.
- Need time to adjust workflow and shortcut usage.
