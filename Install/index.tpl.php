<?php declare(strict_types=1);
/** @var \phpOMS\Views\View $this View */?><!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="../jsOMS/Utils/oLib.js"></script>
    <script src="../jsOMS/Asset/AssetManager.js"></script>
    <script src="../jsOMS/Autoloader.js"></script>
    <script src="../jsOMS/Log/Logger.js"></script>
    <script src="../jsOMS/Log/LogLevel.js"></script>
    <script src="../jsOMS/Uri/Http.js"></script>
    <script src="../jsOMS/Uri/UriFactory.js"></script>
    <script src="../jsOMS/Event/EventManager.js"></script>
    <script src="../jsOMS/Message/Request/BrowserType.js"></script>
    <script src="../jsOMS/Message/Request/OSType.js"></script>
    <script src="../jsOMS/Message/Request/RequestMethod.js"></script>
    <script src="../jsOMS/Message/Request/RequestType.js"></script>
    <script src="../jsOMS/Message/Request/Request.js"></script>
    <script src="../jsOMS/Message/Response/ResponseType.js"></script>
    <script src="../jsOMS/Message/Response/ResponseManager.js"></script>
    <script src="../jsOMS/Message/Response/Response.js"></script>
    <script src="../jsOMS/UI/Component/Form.js"></script>
    <script src="../jsOMS/Views/FormView.js"></script>
    <script src="../jsOMS/Model/Message/Redirect.js"></script>
</head>
<body>
<main>
    <div id="page-1" class="page">
        <section>
            <img alt="Logo" src="img/logo.png" class="logo" width="50">
            <h1>Welcome</h1>
            <div>
                <p>Orange Management is a WebApp written in PHP and JavaScript supporting various database
                and caching technologies. Many Modules/Extensions provide functionality for businesses,
                education facilities, healthcare facilities and organizations in general.<p>

                <p>In the following pages you'll be guided through the installation process for the WebApp.
                Most of the customization can be done after installation such as configuring localization,
                installing additional modules, creating organization etc.</p>

                <p>In case you don't want to use this web installation tool you can also use the console
                installation tool. Just navigate in your shell to the install directory and then into
                Console the subdirectory. There you simply run the install script and are good to go.</p>

                <p>In case you encounter any problems during the installation process please feel free to
                ask for help on our website or contact our support email at
                <strong>test.email@orange-management.de</strong></p>

                <p><button class="next">Next</button></p>
            </div>
        </section>
    </div>
    <div id="page-2" class="page">
        <section>
            <img alt="Logo" src="img/logo.png" class="logo" width="50">
            <h1>License &amp; User Agreement</h1>
            <div>
                <p>Upon clicking Agree you agree with the following license agreement.</p>

                <blockquote>
                    <p>The OMS License 1.0</p>

                    <p>Copyright (c) <Dennis Eichhorn> All Rights Reserved</p>

                    <p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
                    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
                    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
                    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
                    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
                    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
                    THE SOFTWARE.</p>
                </blockquote>

                <p><button class="prev">Previous</button><button class="next">Agree</button></p>
            </div>
        </section>
    </div>
    <div id="page-3" class="page">
        <section>
            <img alt="Logo" src="img/logo.png" class="logo" width="50">
            <h1>Pre-installation check</h1>
            <div>
                <p>The following checks show if your environment supports the necessary requirements of the WebApp.</p>

                <p>Right next to the check status you can see the type of the requirement. Anything crictial will
                prevent you from installing the WebApp and must be fixed. Medium indicates that some important features
                are not available but the WebApp can be still installed. Optional means that only minor features are not
                available.</p>

                <p>All non critical elements can be fixed after installation if you find yourself in need of one of the
                features. All critical elements must be fixed before you can continue with the installation.</p>

                <p>For help please check our <a href="https://orange-management.org">Installation Guide</a>.</p>
                <?php $isOK = \version_compare('7.2.0', \PHP_VERSION) < 1 && \extension_loaded('pdo'); ?>
                <table>
                    <thead>
                        <tr>
                            <th>Status
                            <th>Type
                            <th>Requirement
                            <th>Your Environment
                    <tbody>
                        <tr>
                            <td class="<?= \version_compare('7.2.0', \PHP_VERSION) < 1 ? 'OK' : 'FAILED'; ?>"><?= \version_compare('7.2.0', \PHP_VERSION) < 1 ? 'OK' : 'FAILED'; ?>
                            <td>Critcal
                            <td>PHP version >= 7.2.0
                            <td><?= \PHP_VERSION; ?>
                        <tr>
                            <td class="<?= \extension_loaded('pdo') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('pdo') ? 'OK' : 'FAILED'; ?>
                            <td>Critcal
                            <td>PDO database extension for PHP
                            <td><?= \extension_loaded('pdo') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('imap') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('imap') ? 'OK' : 'FAILED'; ?>
                            <td>Medium
                            <td>IMAP extension for PHP
                            <td><?= \extension_loaded('imap') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('curl') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('curl') ? 'OK' : 'FAILED'; ?>
                            <td>Medium
                            <td>cUrl extension for PHP
                            <td><?= \extension_loaded('curl') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('ftp') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('ftp') ? 'OK' : 'FAILED'; ?>
                            <td>Medium
                            <td>FTP extension for PHP
                            <td><?= \extension_loaded('ftp') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('dom') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('dom') ? 'OK' : 'FAILED'; ?>
                            <td>Medium
                            <td>Dom extension for PHP
                            <td><?= \extension_loaded('dom') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('xml') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('xml') ? 'OK' : 'FAILED'; ?>
                            <td>Medium
                            <td>Xml extension for PHP
                            <td><?= \extension_loaded('xml') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('bcmath') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('bcmath') ? 'OK' : 'FAILED'; ?>
                            <td>Medium
                            <td>BCMath extension for PHP
                            <td><?= \extension_loaded('bcmath') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('mbstring') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('mbstring') ? 'OK' : 'FAILED'; ?>
                            <td>Optional
                            <td>Multibyte extension (mbstring) for PHP for international characters (e.g. chinese, russian)
                            <td><?= \extension_loaded('mbstring') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('zip') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('zip') ? 'OK' : 'FAILED'; ?>
                            <td>Optional
                            <td>Zip extension for PHP
                            <td><?= \extension_loaded('zip') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('zlib') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('zlib') ? 'OK' : 'FAILED'; ?>
                            <td>Optional
                            <td>Zlib extension for PHP
                            <td><?= \extension_loaded('zlib') ? 'Available' : 'Not installed'; ?>
                        <tr>
                            <td class="<?= \extension_loaded('gd') ? 'OK' : 'FAILED'; ?>"><?= \extension_loaded('gd') ? 'OK' : 'FAILED'; ?>
                            <td>Optional
                            <td>Gd extension for PHP
                            <td><?= \extension_loaded('gd') ? 'Available' : 'Not installed'; ?>
                </table>

                <p><strong>Tip:</strong> Many PHP extension just need to be activated in your php.ini file located
                at <?= \php_ini_loaded_file(); ?>. Reload the installation in your browser after making any adjustments.</p>

                <p><button class="prev">Previous</button><button class="next"<?= !$isOK ? ' disabled' : ''?>>Next</button></p>
            </div>
        </section>
    </div>
    <div id="page-4" class="page">
        <section>
            <img alt="Logo" src="img/logo.png" class="logo" width="50">
            <h1>Database</h1>
            <div>
                <p>Please create a database this WebApp can use and configure every field.</p>

                <form id="installForm" name="installForm" method="put" action="<?= $this->request->getUri()->__toString(); ?>">
                    <ul>
                        <li><label for="iDbHost">Address</label>
                        <li><input id="iDbHost" name="dbhost" type="text" value="127.0.0.1" required>
                        <li><label for="iDbType">Type</label>
                        <li><select id="iDbType" name="dbtype">
                                <option value="mysql" selected>MySQL
                                <option value="postgresql">PostgreSQL
                                <option value="mssql">MSSQL
                            </select>
                        <li><label for="iDbPort">Port</label>
                        <li><input id="iDbPort" name="dbport" type="number" value="3306" required>
                        <li><label for="iDbName">Database</label>
                        <li><input id="iDbName" name="dbname" type="text" value="oms" required>
                    </ul>
                </form>

                <h2>Users</h2>

                <p>This WebApp uses different database users for different tasks. This way permissions can be
                managed in a batter way which also helps to improve the security. You can use always the same
                user and give that user the necessary permissions, this however is not advised. Please make
                sure every user only has the necessary permissions assigned.</p>

                <h3>Schema</h3>

                <p>The schema user is responsible for modifying the database structure and is only used during
                the installation and potentially during updates if the database needs to be modified.</p>

                <ul>
                    <li><label for="iSchemaUser">User</label>
                    <li><input id="iSchemaUser" name="schemauser" type="text" form="installForm" required>
                    <li><label for="iSchemaPassword">Password</label>
                    <li><input id="iSchemaPassword" name="schemapassword" type="password" form="installForm">
                </ul>

                <h3>Create</h3>

                <p>The create user is only used by the API for creating new database entries.</p>

                <ul>
                    <li><label for="iCreateUser">User</label>
                    <li><input id="iCreateUser" name="createuser" type="text" form="installForm" required>
                    <li><label for="iCreatePassword">Password</label>
                    <li><input id="iCreatePassword" name="createpassword" type="password" form="installForm">
                </ul>

                <h3>Select</h3>

                <p>The select user is used by every part of the WebApp to read database entries.</p>

                <ul>
                    <li><label for="iSelectUser">User</label>
                    <li><input id="iSelectUser" name="selectuser" type="text" form="installForm" required>
                    <li><label for="iSelectPassword">Password</label>
                    <li><input id="iSelectPassword" name="selectpassword" type="password" form="installForm">
                </ul>

                <h3>Update</h3>

                <p>The update user is only used by the API for updating existing database entries.</p>

                <ul>
                    <li><label for="iUpdateUser">User</label>
                    <li><input id="iUpdateUser" name="updateuser" type="text" form="installForm" required>
                    <li><label for="iUpdatePassword">Password</label>
                    <li><input id="iUpdatePassword" name="updatepassword" type="password" form="installForm">
                </ul>

                <h3>Delete</h3>

                <p>The delete user is only used by the API for deleting existing database entries. </p>

                <ul>
                    <li><label for="iDeleteUser">User</label>
                    <li><input id="iDeleteUser" name="deleteuser" type="text" form="installForm" required>
                    <li><label for="iDeletePassword">Password</label>
                    <li><input id="iDeletePassword" name="deletepassword" type="password" form="installForm">
                </ul>

                <p><button class="prev">Previous</button><button class="next">Next</button></p>
            </div>
        </section>
    </div>
    <div id="page-5" class="page">
        <section>
            <img alt="Logo" src="img/logo.png" class="logo" width="50">
            <h1>Configuration</h1>
            <div>
                <p>The following configuration options are general WebApp settings.</p>
                <ul>
                    <li><label for="iOrgName">Organization Name</label>
                    <li><input id="iOrgName" name="orgname" type="text" value="Orange-Management" form="installForm" required>
                    <li><label for="iAdminName">Admin Login</label>
                    <li><input id="iAdminName" name="adminname" type="text" value="admin" form="installForm" required>
                    <li><label for="iAdminPassword">Admin Password</label>
                    <li><input id="iAdminPassword" name="adminpassword" type="password" form="installForm" required>
                    <li><label for="iAdminEmail">Admin Email</label>
                    <li><input id="iAdminEmail" name="adminemail" type="email" form="installForm" required>
                    <li><label for="iDomain">Top Level domain</label>
                    <li><input id="iDomain" name="domain" type="text" value="<?= $this->request->getUri()->getHost(); ?>" form="installForm" placeholder="demo.com" pattern="^((?!(www\.|http)).)*$" required>
                    <li><label for="iWebSubdir">Web Subdirectory</label>
                    <li><input id="iWebSubdir" name="websubdir" type="text" value="/<?= \substr($this->request->getUri()->getPath(), \stripos($this->request->getUri()->getPath(), 'Install/')+8); ?>" form="installForm" required>
                    <li><label for="iDefaultLang">Default Language</label>
                    <li><select id="iDefaultLang" name="defaultlang" form="installForm">
                            <option value="en" selected>English
                        </select>
                </ul>
                <p><button class="prev">Previous</button><button class="install" type="submit" form="installForm">Install</button></p>
            </div>
        </section>
    </div>
    <div id="page-6" class="page">
        <section>
            <img alt="Logo" src="img/logo.png" class="logo" width="50">
            <h1>Installation</h1>
            <div>
                <p>Please wait until the installation finishes. You will be redirected to the backend
                afterwards.</p>
                </div>
        </section>
    </div>
</main>
<script>
jsOMS.ready(function ()
{
    /* navigation */
    const nextButtons     = Array.prototype.slice.call(document.getElementsByClassName('next')),
        prevButtons       = Array.prototype.slice.call(document.getElementsByClassName('prev')),
        nextButtonsLength = nextButtons.length;
        prevButtonsLength = prevButtons.length;

    for (let i = 0; i < nextButtonsLength; ++i) {
        nextButtons[i].addEventListener('click', function() {
            let index = nextButtons.indexOf(this);

            document.getElementsByTagName('main')[0].setAttribute(
                'style',
                'margin-left: ' + ((index + 1) * -100) + '%;'
            );
        });
    }

    for (let i = 0; i < prevButtonsLength; ++i) {
        prevButtons[i].addEventListener('click', function() {
            let index = prevButtons.indexOf(this);

            document.getElementsByTagName('main')[0].setAttribute(
                'style',
                'margin-left: ' + (index * -100) + '%;'
            );
        });
    }

    /* setup App */
    const app = {
        responseManager: new jsOMS.Message.Response.ResponseManager(),
        eventManager: new jsOMS.Event.EventManager()
    };

    app.responseManager.add('redirect', redirectMessage);

    const formManager = new jsOMS.UI.Component.Form(app),
        logger        = jsOMS.Log.Logger.getInstance();

    window.logger = logger;
    formManager.bind('installForm');
    formManager.get('installForm').injectSubmit(function(e) {
        const valid = e.isValid();

        if (valid) {
            document.getElementsByTagName('main')[0].setAttribute(
                'style',
                'margin-left: ' + (5 * -100) + '%;'
            );
        } else {
            window.alert('You didn\'t fill out all required configuration fields. Please check your settings also on the previous pages.');
        }

        app.eventManager.trigger(e.id);

        return valid;
    });
    formManager.get('installForm').setSuccess(function(e) {
        window.location.replace('http://' + document.getElementById('iDomain').value + document.getElementById('iWebSubdir').value + 'en/backend');
    });
});
</script>
