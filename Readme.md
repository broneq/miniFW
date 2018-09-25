**MiniFw - Mini framework inspired by Phalcon framework**

Framework inspired by Phalcon to do simple thinks on not dedicated servers.

**Usage**

composer install broneq/miniFW

```
use MiniFw\Lib\Di;
include __DIR__.'/Lib/Autoloader.php';
$autoloader = new \MiniFw\Lib\Autoloader();
$autoloader->registerNamespace('MiniFw', __DIR__.'/pathtovendor');
$autoloader->registerNamespace('SomeOtherNameSpace', __DIR__.'/otherdir');
$auth = new MiniFw\Lib\Auth;
$router = new \MiniFw\Lib\Router();

$auth->addUser('admin', 'sha1encodedpassword');
$auth->authRequest();

Di::register('auth', $auth);
Di::register('router', $router);
Di::register('db', new \MiniFw\Lib\Db(__DIR__ . '/private/db.sqlite'));
Di::register('view', new \MiniFw\Lib\View(__DIR__ . '/tpl'));
$router->registerNotFoundAction(function () {
    header("HTTP/1.0 404 Not Found");
    echo "Page not found.\n";
    die();
});
$router->registerDefaultController('index');
$router->handle($_GET);

``` 

*Sample controller*
```
class File extends BaseController
{
    public function indexAction(): void
    {
        $this->view->render('file/list', ['data' => ['title'=>'test']);
    }
}
```

*Sample model*
```
class InquiryFile extends BaseModel
{
    public $inquiry_id;

    public $title;

    public $file_name;

    public $file;

    protected function sanitize(): void
    {
        if ($this->id) {
            $this->id = (int)$this->id;
        }
        $this->inquiry_id = (int)$this->inquiry_id;
        if (!$this->inquiry_id) {
            throw new \ErrorException('No inquiry_id provided');
        }
        $this->title = strip_tags(trim($this->title), ENT_QUOTES);
        $this->file_name = strip_tags(trim($this->file_name), ENT_QUOTES);
    }
}
```
