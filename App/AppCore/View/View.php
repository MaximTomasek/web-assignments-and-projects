<?php

declare(strict_types=1);

namespace App\AppCore\View;

use App\AppCore\Utils\Debug;

class View
{
    /**
     * @param string $template název šablony
     * @param array $data data, která budou zobrazena v šabloně - asociativní pole ['title' => 'Přihlášení']
     */
    public function __construct(
        private readonly string $template,
        private array $data = []
    )
    {
    }

    public function render(): void
    {
        $templateFile = __APP_ROOT__ . getenv('APP_PRIVATE_SUB_FOLDERS') . 'App/Views/' . $this->template . '.php';

        if (file_exists($templateFile)) {
            require $templateFile;
        }
    }

    public static function make(
        string $template,
        array $data = []
    ): View
    {
        $view = new View($template, $data);
        $view->render();
        return $view;
    }
}