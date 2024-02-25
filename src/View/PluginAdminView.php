<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\View;

class PluginAdminView extends AbstractView
{
    public function render(): ?string
    {
        $props = $this->getProps();

        ?>
            <h2><?= $props['title']?></h2>
            <div class="explaination">
                <h3>What is this plugin</h3>
                <p>......</p>
                <h3>How does it work ?</h3>
                <p>......</p>
                <hr>
                <h5>Plugin developed by <a href="mailto:loudefaut02@outlook.fr">Louis
                    Defaut</a>. Here find my website <a href="https://louisdefaut.fr"
                    target="_blank">louisdefaut.fr</a></h5>
            </div>
        <?php

        return null;
    }
}
