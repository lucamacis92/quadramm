# quadramm

Il progetto è stato realizzato seguendo il pattern mvc.
I controller implementati sono base (per utenti non registrati), buyer, 
seller e admin. Le view sono organizazzate in base ai controller, nella share quelle condivise.
L'utente non registrato non può acquistare; il buyer può scegliere il quadro da comprare e acquistarlo dal carrello;
il seller può creare un negozio, vendere quadri, aggiungere quadri al negozio, toglierli, confermare la spedizione
e comportarsi come un buyer; l'admin può impersonare gli utenti registrati e comportarsi in base al loro ruolo.

Gli user e password esistenti:

user: pippoverdi  password: pippo   ruolo: buyer

user: lucamacis   password: luca    ruolo: seller

user: admin       password: admin   ruolo: admin
