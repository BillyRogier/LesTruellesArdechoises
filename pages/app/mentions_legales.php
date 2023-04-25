<main class="mentions-container grid">
    <h1 class="contact_title">Mentions légales</h1>
    <div class="mentions grid">
        <div class="mention grid">
            <h2 class="contact_title">EDITEUR DU SITE</h2>
            <p>
                Le site internet <?= $_SERVER['SERVER_NAME'] ?> est la propriété de la société : <?= $info->getEtp_name() ?>.
                Si vous souhaitez contacter le propriétaire du site internet, vous pouvez cliquez sur le bouton « Contact » du menu principal.
            </p>
        </div>
        <div class="mention grid">
            <h2 class="contact_title">ACCÈS</h2>
            <p>
                Le site <?= $_SERVER['SERVER_NAME'] ?> est un site d’information de langue française qui s’adresse à tous. Les informations mises à disposition sur le site ont un caractère strictement informatif et n’emportent aucun engagement juridique ni accord contractuel, explicite ou implicite, de la société : <?= $info->getEtp_name() ?>, qui se réserve par ailleurs la faculté d’en modifier les caractéristiques à tout moment.
            </p>
        </div>
        <div class="mention grid">
            <h2 class="contact_title">PROPRIÉTÉ INTELLECTUELLE</h2>
            <p>Le site Web est protégé par les droits de propriété intellectuelle et est la propriété exclusive de la société : <?= $info->getEtp_name() ?>. La conception, le graphisme, le contenu, l’organisation de ce site sont des oeuvres originales et sont l’entière propriété de la société : <?= $info->getEtp_name() ?>. Toute reproduction, ou démarquage, total ou partiel, fait sans le consentement de l’auteur, ou de ses ayants droit, ou de ses ayants cause est illicite. Il en est de même pour la traduction, l’adaptation, l’arrangement par quelque procédé que ce soit (Loi 57298 du 11 mars 1957).</p>
        </div>
        <div class="mention grid">
            <h2 class="contact_title">MODIFICATION NOTICE LÉGALE</h2>
            <p>
                <?= $_SERVER['SERVER_NAME'] ?> se réserve le droit de modifier ou de corriger le contenu de ce site et cette mention légale à tout moment et ceci sans préavis.
                Date de la dernière mise à jour : Avril 2023
            </p>
        </div>
        <div class="mention grid">
            <h2 class="contact_title">HÉBERGEMENT</h2>
            <p>
                <?= $info->getHost_name() ?><br>
                <?= $info->getHost_location() ?><br>
                <?= $info->getHost_number() ?>
            </p>
        </div>
        <div class="mention grid">
            <h2 class="contact_title">CONCEPTEUR DU SITE</h2>
            <p>
                Billy Rogier <br>
                billy.rogier@free.fr</p>
        </div>
    </div>
</main>