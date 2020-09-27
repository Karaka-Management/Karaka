<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

$head = $this->getData('head');
?>
<!DOCTYPE HTML>
<html lang="<?= $this->printHtml($this->response->getHeader()->getL11n()->getLanguage()); ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <base href="<?= UriFactory::build('{/base}'); ?>/">
    <meta name="theme-color" content="#343a40">
    <meta name="msapplication-navbutton-color" content="#343a40">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343a40">
    <meta name="description" content="<?= $this->getHtml(':meta', '0', '0'); ?>">
    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.json'); ?>">
    <link rel="manifest" href="<?= UriFactory::build('Web/Backend/manifest.webmanifest'); ?>">
    <link rel="shortcut icon" href="<?= UriFactory::build('Web/Backend/img/favicon.ico'); ?>" type="image/x-icon">
    <?= $head->getMeta()->render(); ?>
    <title><?= $this->printHtml($head->getTitle()); ?></title>
    <style><?= $head->renderStyle(); ?></style>
    <script><?= $head->renderScript(); ?></script>
    <?= $head->renderAssets(); ?>
</head>
<body>
<main>
    <article>
    <h1>Privacy Policy</h1>
    <p>This privacy policy ("POLICY") will help you understand how [name] ("us", "we", "our") uses and protects the data you provide to us when you visit and use Orange-Management ("website", "service" and "application").</p>

    <h2>Definitions</h2>
    <p>For the purposes of these POLICIES:<p>

    <ul>
        <li>AFFILIATED means an entity that controls, is controlled by or is under common control with a party, where "control" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</li>
        <li>COUNTRY refers to Germany</li>
        <li>COMPANY (referred to as either "the Company", "We", "Us" or "Our" in this AGREEMENT) refers to Orange Management, Gartenstr. 26, 61206 Woellstadt.</li>
        <li>DEVICE means any device that can access the SERVICE such as a computer, a cellphone or a digital tablet.</li>
        <li>SERVICE refers to the Website</li>
        <li>POLICY or AGREEMENT mean these policies that form the entire agreement between You and the COMPANY regarding the use of the SERVICE.</li>
        <li>Third-party Social Media SERVICE means any services or content (including data, information, products or services) provided by a third-party that may be displayed, included or made available by the SERVICE.</li>
        <li>WEBSITE refers to orange-management.org (.net, .app, .service, .support, .email, .de, .solutions)</li>
        <li>APPLICATION refers to all downloadable or installable content which can therfore be used on an a given DEVICE.</li>
        <li>You means the individual accessing or using the SERVICE, or the company, or other legal entity on behalf of which such individual is accessing or using the SERVICE, as applicable.</li>
    </ul>

    <h2>What User Data we Collect</h2>
    <p>When you visit the WEBSITE or APPLICATION, we may collect the following data:</p>

    <ul>
        <li>Your IP address.</li>
        <li>Your contact information and email address.</li>
        <li>Data profile regarding your online behavior on our WEBSITE.</li>
    </ul>

    <h2>Why We Collect Your Data</h2>
    <p>We are collecting your data for several reasons:</p>

    <ul>
        <li>To better understand your needs.</li>
        <li>To improve our SERVICES and products.</li>
        <li>To send you promotional emails containing the information we think you will find interesting.</li>
        <li>To contact you to fill out surveys and participate in other types of market research.</li>
        <li>To customize our WEBSITE according to your online behavior and personal preferences.</li>
    </ul>

    <h2>Safeguarding and Securing the Data</h2>
    <p>Orange-Management is committed to securing your data and keeping it confidential. Orange-Management has done all in its power to prevent data theft, unauthorized access, and disclosure by implementing the latest technologies and software, which help us safeguard all the information we collect online.</p>

    <h2>Our Cookie Policy</h2>
    <p>Once you agree to allow our WEBSITE or APPLICATION to use cookies, you also agree to these POLICIES.</p>
    <p>Please note that cookies don't allow us to gain control of your computer in any way.</p>
    <p>If you want to disable cookies, you can do it by accessing the settings of your internet browser.</p>
    <p>Please note that some functionality cannot be made available to you if you don't accept cookies</p>

    <h2>Links</h2>
    <p>Our SERVICE may contain links to third-party web sites or services that are not owned or controlled by the COMPANY.</p>
    <p>The COMPANY has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party websites or services. You further acknowledge and agree that the COMPANY shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods or services available on or through any such websites or services.</p>
    <p>We strongly advise You to read the terms and conditions and privacy policies of any third-party web sites or services that You visit.</p>

    <h2>Restricting the Collection of your Personal Data</h2>
    <p>At some point, you might wish to restrict the use and collection of your personal data. You can achieve this by doing the following:</p>

    <ul>
        <li>Don't accept cookies from our WEBSITE and APPLICATION</li>
        <li>If you have already agreed to share your information with us, feel free to contact us via email and we will be more than happy to change this for you.</li>
    </ul>

    <p>Orange-Management will not lease, sell or distribute your personal information to any third parties, unless we have your permission. We might do so if the law forces us. Your personal information will be used when we need to send you promotional materials if you agree to this privacy policy.</p>

    <h2>Governing Law</h2>
    <p>The laws of the COUNTRY, excluding its conflicts of law rules, shall govern this POLICY and Your use of the SERVICE. Your use of the APPLICATION may also be subject to other local, state, national, or international laws.</p>
    <p>The ineffectiveness of one or more provisions of this agreement does not affect the validity of the others. Each party to these TERMS can in this case demand that a new valid provision be agreed which best achieves the economic purpose of the ineffective provision.</p>

    <h2>Dispute Resolution</h2>
    <p>If You have any concern or dispute about the SERVICE, You agree to first try to resolve the dispute informally by contacting the COMPANY.</p>

    <h2>Changes to these Policies</h2>
    <p>We reserve the right, at Our sole discretion, to modify or replace these POLICIES at any time. If a revision is material We will make reasonable efforts to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at Our sole discretion.</p>
    <p>By continuing to access or use Our SERVICE after those revisions become effective, You agree to be bound by the revised policies. If You do not agree to the new policies, in whole or in part, please stop using the WEBSITE and the SERVICE.</p>

    <h2>Contact</h2>
    <p>For questions regarding these POLICIES please feel free to contact us at info@orange-management.email</p>
    </article>
</main>
<footer>
    <ul>
        <li><a href="<?= UriFactory::build('{/backend}?{?}'); ?>"><?= $this->getHtml('Login', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/prefix}privacy?{?}'); ?>"><?= $this->getHtml('PrivacyPolicy', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/prefix}terms?{?}'); ?>"><?= $this->getHtml('Terms', '0', '0'); ?></a>
        <li><a href="<?= UriFactory::build('{/prefix}imprint?{?}'); ?>"><?= $this->getHtml('Imprint', '0', '0'); ?></a>
    </ul>
</footer>

<?= $head->renderAssetsLate(); ?>