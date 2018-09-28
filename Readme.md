**MiniFw - Mini framework inspired by Phalcon framework**

Framework inspired by Phalcon to do simple thinks on not dedicated servers.

**Usage**

composer install broneq/miniFW

```
use MiniFwSample\Config\Sample;

include __DIR__.'/Lib/Autoloader.php';
$autoloader = new \MiniFw\Lib\Autoloader();
$autoloader->registerNamespace('MiniFw', __DIR__.'/pathtovendor');
$autoloader->registerNamespace('SomeOtherNameSpace', __DIR__.'/otherdir');

try {
    new Sample();
} catch (Exception $e) {
    http_response_code(500);
    echo 'FATAL: ' . $e->getMessage();
}

``` 

*Sample config*

```
namespace MiniFwSample\Config;


use MiniFw\Lib\Auth;
use MiniFw\Lib\Db;
use MiniFw\Lib\Di\BaseConfig;
use MiniFw\Lib\Di\Dependency;
use MiniFw\Lib\Router;
use MiniFw\Lib\View;

class Sample extends BaseConfig
{
    /**
     * Sample constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->addDependency((new Dependency('auth', Auth::class))
            ->addCall('addUser', 'broneq', 'sha1password')
            ->addCall('authRequest'));
        //
        $this->addDependency((new Dependency('router', Router::class))
            ->addParameter('\'MiniFwSample\Controller\\')
            ->addCall('registerNotFoundAction', function () {
                header("HTTP/1.0 404 Not Found");
                echo "Page not found.\n";
                die();
            })
            ->addCall('registerDefaultController', 'index')
            ->addCall('handle', $_GET)
        );
        //
        $this->addDependency((new Dependency('db', Db::class))
            ->addParameter(__DIR__ . '/../db.sqlite'));
        //
        $this->addDependency((new Dependency('view', View::class))
            ->addParameter(__DIR__ . '/../view'));
        //
        //
        $this->autorun('router');
        $this->autorun('auth');
        $this->autorun('view');
        //
        $this->build();
    }
}
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
