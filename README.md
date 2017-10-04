# Raspitimelapse
Time-lapse video con Raspberry Pi

Composto da due parti indipendenti tra loro:
  - timelapse.py - script Python
  - WebGui - serie di script PHP per scatto e controllo remoto

L'esecuzione contemporanea dello script Python e PHP potrebbe creare problemi. 

## timelapse.py
### Per avviare lo script:
```
python timelapse.py -d [DELAY] -t [DURATION] -f [FOLDER]
```
### Parametri:
  - -d secondi tra ogni scatto (dafault: 5)
  - -t durata del timelapse in minuti (default: 0.2)
  - -f cartella dove salvare le immagini (default: /home/pi/camera/)
  
## WebGui
### Configurazione iniziale:
Nel file config.php impostare la path dove si trovano gli script e le credenziali per accedere all'interfaccia web (maggiori info nel file config.php).

### Avvio dello script:
Per funzionare correttamente, lo script timelapse.php deve essere sempre in esecuzione.
Controllare inoltre che l'utente che lo esegue e l'utente www-data hanno i permessi di scrittura nella cartella dello script e nelle sottocartelle.

### Controllo remoto:
Da un browser richiamare lo script index.php e effettuare il login con le credenziali scelte in precedenza.
Tramite il pulsante sulla home è possibile avviare un timelapse, scegliendo il nome, il delay tra ogni scatto e la durata.
Sulla home inoltre è presente anche un anteprima, aggiornata ogni 5 secondi.
Se c'è un timelapse attivo, per non creare problemi, l'anteprima che viene mostrata sulla home è l'ultima immagine scattata.
