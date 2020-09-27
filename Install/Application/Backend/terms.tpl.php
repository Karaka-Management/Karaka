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
    <h1>Terms of Service</h1>

    <h2>Definitions</h2>
    <p>For the purposes of these TERMS:<p>

    <ul>
    <li>AFFILIATED means an entity that controls, is controlled by or is under common control with a party, where "control" means ownership of 50% or more of the shares, equity interest or other securities entitled to vote for election of directors or other managing authority.</li>
    <li>COUNTRY refers to Germany</li>
    <li>COMPANY (referred to as either "the Company", "We", "Us" or "Our" in this AGREEMENT) refers to Orange Management, Gartenstr. 26, 61206 Woellstadt.</li>
    <li>DEVICE means any device that can access the Service such as a computer, a cellphone or a digital tablet.</li>
    <li>SERVICE refers to the Website</li>
    <li>TERMS or AGREEMENT mean these terms that form the entire agreement between You and the COMPANY regarding the use of the SERVICE.</li>
    <li>Third-party Social Media Service means any services or content (including data, information, products or services) provided by a third-party that may be displayed, included or made available by the SERVICE.</li>
    <li>WEBSITE refers to orange-management.org (.net, .app, .service, .support, .email, .de, .solutions)</li>
    <li>APPLICATION refers to all downloadable or installable content which can therfore be used on an a given DEVICE.</li>
    <li>You means the individual accessing or using the SERVICES, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</li>
    </ul>

    <h2>Acknowledgement</h2>
    <p>These are the TERMS governing the use of this SERVICE and the agreement that operates between You and the COMPANY. These TERMS set out the rights and obligations of all users regarding the use of the SERVICE.</p>
    <p>Your access to and use of the SERVICE is conditioned on Your acceptance of and compliance with these TERMS. These TERMS apply to all visitors, users and others who access or use the SERVICE.</p>
    <p>By accessing or using the SERVICE You agree to be bound by these TERMS. If You disagree with any part of these TERMS then You may not access the SERVICE.<p>
    <p>You represent that you are at least over the age of 18 and be over the Age of Majority. The COMPANY does not permit those under 18 or the Age of Majurity to use the SERVICE.</p>
    <p>Your access to and use of the SERVICE is also conditioned on Your acceptance of and compliance with the Privacy Policy of the COMPANY. Our Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your personal information when You use the Application or the WEBSITE and tells You about Your privacy rights and how the law protects You. Please read Our Privacy Policy carefully before using Our SERVICE.</p>

    <h2>Copyright</h2>
    <p>Unless otherwise noted, all materials including without limitation, logos, brand names, images, designs, photographs, videos, audio, source code and written and other materials that appear as part of our WEBSITE are copyrights, trademarks, service marks, trade dress and/or other intellectual property whether registered or unregistered ("Intellectual Property") owned, controlled or licensed by Orange-Management. Our WEBSITE as a whole is protected by copyright and trade dress. Nothing on our WEBSITE should be construed as granting, by implication, estoppel or otherwise, any license or right to use any Intellectual Property displayed or used on our WEBSITE, without the prior written permission of the Intellectual Property owner. Orange-Management aggressively enforces its intellectual property rights to the fullest extent of the law. The names and logos of Orange-Management, may not be used in any way, including in advertising or publicity pertaining to distribution of materials on our WEBSITE, without prior, written permission from Orange-Management. Orange-Management prohibits use of any logo of Orange-Management or any of its affiliates as part of a link to or from any WEBSITE unless Orange-Management approves such link in advance and in writing. Fair use of Orange-Management Intellectual Property requires proper acknowledgment. Other product and company names mentioned in our Website may be the Intellectual Property of their respective owners.</p>

    <h2>Links</h2>
    <p>Our SERVICE may contain links to third-party web sites or services that are not owned or controlled by the COMPANY.</p>
    <p>The COMPANY has no control over, and assumes no responsibility for, the contentthird-party web sites or services that You visit.</p>

    <h2>Termination</h2>
    <p>We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if You breach these TERMS.</p>
    <p>Upon termination, Your right to use the SERVICE will cease immediately.</p>

    <h2>Limitation of Liability</h2>
    <p>Notwithstanding any damages that You might incur, the entire liability of the COMPANY and any of its suppliers under any provision of this TERMS and Your exclusive remedy for all of the foregoing shall be limited to the amount actually paid by through the SERVICE.</p>
    <p>To the maximum extent permitted by applicable law, in no event shall the COMPANY or its suppliers be liable for any special, incidental, indirect, or consequential damages whatsoever (including, but not limited to, damages for loss of profits, loss of data or other information, for business interruption, for personal injury, loss of privacy arising out of or in any way related to the use of or inability to use the SERVICE, third-party software and/or third-party hardware used with the SERVICE, or otherwise in connection with any provision of this TERMS), even if the COMPANY or any supplier has been advised of the possibility of such damages and even if the remedy fails of its essential purpose.</p>
    <p>Some states or countries do not allow the exclusion of implied warranties or limitation of liability for incidental or consequential damages, which means that some of the above limitations may not apply. In these states or countries, each party's liability will be limited to the greatest extent permitted by law.</p>

    <h2>Disclaimer</h2>
    <p>The SERVICE is provided to You "AS IS" and "AS AVAILABLE" and with all faults and defects without warranty of any kind. To the maximum extent permitted under applicable law, the COMPANY, on its own behalf and on behalf of its AFFILIATES and its and their respective licensors and service providers, expressly disclaims all warranties, whether express, implied, statutory or otherwise, with respect to the SERVICE, including all implied warranties of merchantability, fitness for a particular purpose, title and non-infringement, and warranties that may arise out of course of dealing, course of performance, usage or trade practice. Without limitation to the foregoing, the COMPANY provides no warranty or undertaking, and makes no representation of any kind that the SERVICE will meet Your requirements, achieve any intended results, be compatible or work with any other software, applications, systems or services, operate without interruption, meet any performance or reliability standards or be error free or that any errors or defects can or will be corrected.</p>
    <p>Without limiting the foregoing, neither the COMPANY nor any of the company's provider makes any representation or warranty of any kind, express or implied: (i) as to the operation or availability of the SERVICE, or the information, content, and materials or products included thereon; (ii) that the SERVICE will be uninterrupted or error-free; (iii) as to the accuracy, reliability, or currency of any information or content provided through the SERVICE; or (iv) that the SERVICE, its servers, the content, or e-mails sent from or on behalf of the COMPANY are free of viruses, scripts, trojan horses, worms, malware, timebombs or other harmful components.</p>
    <p>Some jurisdictions do not allow the exclusion of certain types of warranties or limitations on applicable statutory rights of a consumer, so some or all of the above exclusions and limitations may not apply to You. But in such a case the exclusions and limitations set forth in this section shall be applied to the greatest extent enforceable under applicable law.</p>

    <h2>Governing Law</h2>
    <p>The laws of the COUNTRY, excluding its conflicts of law rules, shall govern these TERMS and Your use of the SERVICE. Your use of the APPLICATION may also be subject to other local, state, national, or international laws.</p>
    <p>The ineffectiveness of one or more provisions of this agreement does not affect the validity of the others. Each party to these TERMS can in this case demand that a new valid provision be agreed which best achieves the economic purpose of the ineffective provision.</p>

    <h2>Dispute Resolution</h2>
    <p>If You have any concern or dispute about the Service, You agree to first try to resolve the dispute informally by contacting the COMPANY.</p>

    <h2>United States Legal Compliance</h2>
    <p>You represent and warrant that (i) You are not located in a country that is subject to the United States government embargo, or that has been designated by the United States government as a "terrorist supporting" country, and (ii) You are not listed on any United States government list of prohibited or restricted parties.</p>

    <h2>Changes to these Terms</h2>
    <p>We reserve the right, at Our sole discretion, to modify or replace these TERMS at any time. If a revision is material We will make reasonable efforts to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at Our sole discretion.</p>
    <p>By continuing to access or use Our SERVICE after those revisions become effective, You agree to be bound by the revised terms. If You do not agree to the new terms, in whole or in part, please stop using the WEBSITE and the SERVICE.</p>

    <h2>Contact</h2>
    <p>For questions regarding these TERMS please feel free to contact us at info@orange-management.email</p>, privacy policies, or practices of any third party websites or services. You further acknowledge and agree that the COMPANY shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such content, goods or services available on or through any such websites or services.</p>
    <p>We strongly advise You to read the terms and conditions and privacy policies of any third-party web sites or services that You visit.</p>

    <h2>Termination</h2>
    <p>We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if You breach these TERMS.</p>
    <p>Upon termination, Your right to use the SERVICE will cease immediately.</p>

    <h2>Limitation of Liability</h2>
    <p>Notwithstanding any damages that You might incur, the entire liability of the COMPANY and any of its suppliers under any provision of this TERMS and Your exclusive remedy for all of the foregoing shall be limited to the amount actually paid by through the SERVICE.</p>
    <p>To the maximum extent permitted by applicable law, in no event shall the COMPANY or its suppliers be liable for any special, incidental, indirect, or consequential damages whatsoever (including, but not limited to, damages for loss of profits, loss of data or other information, for business interruption, for personal injury, loss of privacy arising out of or in any way related to the use of or inability to use the SERVICE, third-party software and/or third-party hardware used with the SERVICE, or otherwise in connection with any provision of this TERMS), even if the COMPANY or any supplier has been advised of the possibility of such damages and even if the remedy fails of its essential purpose.</p>
    <p>Some states or countries do not allow the exclusion of implied warranties or limitation of liability for incidental or consequential damages, which means that some of the above limitations may not apply. In these states or countries, each party's liability will be limited to the greatest extent permitted by law.</p>

    <h2>Disclaimer</h2>
    <p>The SERVICE is provided to You "AS IS" and "AS AVAILABLE" and with all faults and defects without warranty of any kind. To the maximum extent permitted under applicable law, the COMPANY, on its own behalf and on behalf of its AFFILIATES and its and their respective licensors and service providers, expressly disclaims all warranties, whether express, implied, statutory or otherwise, with respect to the SERVICE, including all implied warranties of merchantability, fitness for a particular purpose, title and non-infringement, and warranties that may arise out of course of dealing, course of performance, usage or trade practice. Without limitation to the foregoing, the COMPANY provides no warranty or undertaking, and makes no representation of any kind that the SERVICE will meet Your requirements, achieve any intended results, be compatible or work with any other software, applications, systems or services, operate without interruption, meet any performance or reliability standards or be error free or that any errors or defects can or will be corrected.</p>
    <p>Without limiting the foregoing, neither the COMPANY nor any of the company's provider makes any representation or warranty of any kind, express or implied: (i) as to the operation or availability of the SERVICE, or the information, content, and materials or products included thereon; (ii) that the SERVICE will be uninterrupted or error-free; (iii) as to the accuracy, reliability, or currency of any information or content provided through the SERVICE; or (iv) that the SERVICE, its servers, the content, or e-mails sent from or on behalf of the COMPANY are free of viruses, scripts, trojan horses, worms, malware, timebombs or other harmful components.</p>
    <p>Some jurisdictions do not allow the exclusion of certain types of warranties or limitations on applicable statutory rights of a consumer, so some or all of the above exclusions and limitations may not apply to You. But in such a case the exclusions and limitations set forth in this section shall be applied to the greatest extent enforceable under applicable law.</p>

    <h2>Governing Law</h2>
    <p>The laws of the COUNTRY, excluding its conflicts of law rules, shall govern these TERMS and Your use of the SERVICE. Your use of the APPLICATION may also be subject to other local, state, national, or international laws.</p>
    <p>The ineffectiveness of one or more provisions of this agreement does not affect the validity of the others. Each party to these TERMS can in this case demand that a new valid provision be agreed which best achieves the economic purpose of the ineffective provision.</p>

    <h2>Dispute Resolution</h2>
    <p>If You have any concern or dispute about the Service, You agree to first try to resolve the dispute informally by contacting the COMPANY.</p>

    <h2>United States Legal Compliance</h2>
    <p>You represent and warrant that (i) You are not located in a country that is subject to the United States government embargo, or that has been designated by the United States government as a "terrorist supporting" country, and (ii) You are not listed on any United States government list of prohibited or restricted parties.</p>

    <h2>Changes to these Terms</h2>
    <p>We reserve the right, at Our sole discretion, to modify or replace these TERMS at any time. If a revision is material We will make reasonable efforts to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at Our sole discretion.</p>
    <p>By continuing to access or use Our SERVICE after those revisions become effective, You agree to be bound by the revised terms. If You do not agree to the new terms, in whole or in part, please stop using the WEBSITE and the SERVICE.</p>

    <h2>Contact</h2>
    <p>For questions regarding these TERMS please feel free to contact us at info@orange-management.email</p>
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