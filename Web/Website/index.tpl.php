<!DOCTYPE html>
<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */ 
$head = $this->response->getHead();
?>
<html>
<head>
    <?= $this->printHtml($head->getMeta()->render()); ?>
    <title><?= $this->printHtml($a = $head->getTitle()); ?></title>
    <?= $this->printHtml($head->renderAssets()); ?>
    <style>
        <?= $this->printHtml($head->renderStyle()); ?>
    </style>
    <script>
        <?= $this->printHtml($head->renderScript()); ?>
    </script>
</head>
<body>
<nav>
    <section>
        <div id="logo">Orange Management</div>
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="#">Demo</a></li>
            <li><a href="products/overview.php">Produkt</a></li>
            <li><a href="#">Dokumentation</a></li>
            <li><a href="#">Support</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">About</a></li>
        </ul>
    </section>
</nav>
<header>
    <section>
    </section>
</header>
<div id="container">
    <div id="intro-product">
        <div class="content">
            <div class="news-box">
                <header><h1>News</h1></header>

                <p>
                    Wir sind stolz darauf heute unsere neue Website zu veröffentlichen. Diese Website wird alle
                    wichtigen Information rund um die OMS Software enthalten. Darunter fallen:
                </p>

                <ul>
                    <li>Demo</li>
                    <li>Produkt Infos</li>
                    <li>Dokumentation</li>
                    <li>Support</li>
                    <li>Blog</li>
                </ul>

                <p>
                    Wir halten Sie ständig auf dem neusten Stand in der Entwicklungsphase und hoffen Sie bald mit ersten
                    Produktbildern begeistern zu können. <a href="#">weiter...</a>
                </p>
            </div>

            <div class="front-box">
                <header><h1><i class="fa fa-dollar lf"></i>ERP</h1></header>

                <p>
                    Mit den ERP Software Modulen können Sie bequem Ihren kompletten Workflow planen und organisieren.
                    Hierbei bezahlen Sie jedoch nur für das was Sie wirklich benötigen, so können Sie sich ganz nach
                    Ihren wünschen die Module zusammenstellen und installieren.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-users lf"></i>CRM</h1></header>

                <p>
                    Mit den entsprechenden Modulen lässt sich ohne Probleme ein umfangreiches CRM zusammenstellen, damit
                    Sie Ihre Kundenbeziehungen entsprechend verwalten und verfolgen können. Somit werden Ihnen wichtige
                    Informationen zur Verfügung gestellt und die Kundenzufriedenheit bleibt gewährleistet.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-sitemap lf"></i>Management</h1></header>

                <p>
                    Unsere Module bieten die Möglichkeit schnell und auf einen Blick umfangreiche Reports zu allen
                    möglichen Unternehmensbereiche zu erstellen und helfen Ihnen dabei schnell auf die Informationen
                    zuzugreifen, die Sie brauchen.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-comments lf"></i>Intranet</h1></header>

                <p>
                    News, Kalender, Umfragen, Nachrichten, Multimedia management und vieles mehr können über Module
                    abgedeckt werden und erlauben es Ihnen ein professionelles Intranet aufzubauen um die
                    innerbetriebliche Kommunikation, aber auch den allgemeinen Workflow zu vereinfachen.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-share-alt lf"></i>Website</h1></header>

                <p>
                    Als Unternehmen wollen Sie wahrscheinlich auch eine Webseite aufbauen, um Ihre Präsenz auch Online
                    zu zeigen. Dank der Website Module ist dies ebenfalls möglich und es können ohne großen Aufwand
                    bestehende Module integriert werden und deren Informationen in die Website eingebettet werden.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-flask lf"></i>Tools</h1></header>

                <p>
                    Neben dem umfangreichen Modulangebot für den Workflow in Ihrem Unternehmen, bieten wir auch noch
                    zusätzliche Module an, die vollständig unabhängig von anderen Modulen genutzt werden können und Ihre
                    Arbeit erleichtern sollen. Darunter fallen z.B.: Event & Projekt Management, Umfragen, Charting,
                    etc.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-language lf"></i>International</h1></header>

                <p>
                    Wenn Sie zu den Unternehmen gehören, das auch im Ausland agiert, dann überbrückt die OMS Software
                    einige sprach- und länderspezifische Barrieren für Sie. Dies gilt sowohl für Mitarbeiter im Ausland,
                    aber auch für Kunden und Lieferanten. Die OMS Software ist somit in und für viele Länder nutzbar.
                </p>
            </div>
            <div class="front-box">
                <header><h1><i class="fa fa-cubes lf"></i>Einsatzbereiche</h1></header>

                <p>
                    Unsere Software ist nicht nur für Unternehmen aller Art geeignet (Produzenten, Dienstleister, Händler, etc.),
                    und vielen mehr genutzt werden. Dank des modularen Aufbaus können Sie die Software ebenfalls für
                    Pflegeeinrichtungen (Patientenverwaltung), Bildungseinrichtungen (Unterrichts-, Schüler-, und
                    Lehrerverwaltung) nutzen.
                </p>
            </div>
        </div>
    </div>
    <div id="intro-request">
        <div class="content">
            <div class="feedback-box rf">
                <p>
                    <i class="fa fa-thumbs-o-up rf"></i>Sie haben eine gute Idee für ein Module und würden gerne, dass
                    ein bestehendes Modul um eine oder mehrere Funktionen erweitert wird? Wir freuen uns auf Ihr
                    feedback. Die Meinung unserer Kunden ist uns wichtig und sollten Sie interessante Vorschläge haben
                    würden wir diese entsprechend in unserem Produkt umsetzen. Sogar Ideen zu neuen Modulen setzen wir
                    gerne bei entsprechender Nachfrage um, um Ihnen und Ihren Mitarbeitern die Tools zur Verfügung zu
                    stellen, die Sie benötigen. Ihr Feedback und die Kommunikation mit Ihnen sind für uns äußerst
                    wichtig. Aus diesem Grund versuchen wir auch ständig unsere Kunden auf dem Laufenden zu halten mit
                    bevorstehenden Weiterentwicklungen.
                </p>
            </div>
            <div class="feedback-box lf">
                <p>
                    <i class="fa fa-cloud lf"></i>Einige der Module die Sie installieren können, kommen sogar von
                    Drittanbietern. Somit können Sie von den Ideen Anderer profitieren und deren Softwarelösung in ein
                    einheitliches System integrieren. Diese Module werden dann von unserem Team betreut, als ob sie
                    unsere eigenen wären. Wir stellen somit sicher, dass für Sie als Kunde somit keine
                    Unannehmlichkeiten enstehen und Sie nur Vorteile aus einem solchen System haben. Selbstverständlich
                    überprüfen wir sämtliche Module um Ihnen die Nötige Sicherheit zu geben, dass die Module auch
                    unseren Qualitätsanforderungen entsprechen.
                </p>
            </div>
        </div>
    </div>
    <div id="intro-service">
        <div class="content">
            <div class="service-box rf">
                <p>
                    <i class="fa fa-newspaper-o rf"></i>Der Start mit einer neuen Softwarelösung ist nie einfach, genau
                    aus diesem Grund haben wir für Sie eine große Auswahl an Dokumentationen auf unserer Webseite
                    bereitgestellt. Mit diesen Hilfestellungen wird Ihnen Schritt für Schritt erklärt, wie Sie welche
                    Module am effektivsten nutzen können.
                </p>

                <p>
                    In den Dokumentationen werden jedoch nicht nur die Funktionen der Module genau erklärt, sondern auch
                    wie man diese am Besten einsetzt. Wir legen bei unseren Dokumentationen einen hohen Wert auf
                    Qualität und bieten hierbei nicht nur Dokumente an, sondern haben für Sie auch ganze
                    Videoanleitungen zusammengestellt.
                </p>
            </div>
            <div class="service-box lf">
                <p>
                    <i class="fa fa-lightbulb-o lf"></i>Neben unserem umfangreichen Angebot an Modulen für unsere OMS
                    Software, bieten wir auch noch ausgewählte Dienstleistungen für Sie an, die Sie gerne in Anspruch
                    nehmen können.
                </p>
                <ul>
                    <li>Einmaliges Aufsetzen und Einrichten der Software</li>
                    <li>Installation und Einrichten von Modulen</li>
                    <li>Umfassende Software Schulungen</li>
                    <li>Hosted Software Lösung auf unseren Servern</li>
                    <li>Support auf Abruf</li>
                    <li>Regelmäßige Wartung und Pflege</li>
                </ul>
                <p>
                    Alle unsere Dienstleistungen können an Ihre Bedürfnisse angepasst werden und wir richten uns völlig
                    nach Ihnen. Seien es gesonderte Schulungen mit gewissen Personengruppen in Ihrem Unternehmen oder
                    der Support Umfang. Unsere Flexibilität ist Ihr Gewinn.
                </p>
            </div>
        </div>
    </div>
</div>
<footer>
    <section>
        <div class="footer-box lf">
            <header><h1>Kontakt</h1></header>
            <ul>
                <li><i class="fa fa-envelope"></i>Verkauf</li>
                <li><i class="fa fa-envelope"></i>Support</li>
                <li><i class="fa fa-envelope"></i>Jobs</li>
            </ul>
        </div>
        <div class="footer-box lf">
            <header><h1>Social & Media</h1></header>
            <ul>
                <li><i class="fa fa-twitter-square"></i>Twitter</li>
                <li><i class="fa fa-facebook-square"></i>Facebook</li>
                <li><i class="fa fa-youtube-play"></i>YouTube</li>
            </ul>
        </div>
        <div class="footer-box rf">
            <ul>
                <li>Privacy Policy</li>
                <li>Terms of Use</li>
                <li>Impressum</li>
            </ul>
        </div>
        <div id="copyright">
            &copy; 2013 - 2015 Dennis Eichhorn & OMS All rights reserved
        </div>
    </section>
</footer>
</body>
</html>
