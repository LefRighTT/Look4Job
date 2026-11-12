Look4Job UI update
Extract this zip into your project root (C:\projects\job-board) and choose "Replace" when asked.
Files (all under resources/views/):
  layouts/guest.blade.php
  layouts/navigation.blade.php
  components/primary-button.blade.php
  components/application-logo.blade.php   (new suitcase logo)
  auth/login.blade.php
  auth/register.blade.php
Then in .env change:  APP_NAME=Look4Job   (also in .env.example)
Run: php artisan config:clear
Keep `npm run dev` running, then hard refresh (Ctrl+Shift+R).
