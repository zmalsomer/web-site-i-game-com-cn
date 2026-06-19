<?php
/**
 * LinkCard - 渲染链接卡片 HTML
 */

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $fallbackDomain;

    public function __construct(string $url, string $title = '', string $description = '', string $fallbackDomain = '')
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->fallbackDomain = $fallbackDomain ?: parse_url($url, PHP_URL_HOST) ?: 'example.com';
    }

    /**
     * 生成经过转义的 HTML 卡片
     */
    public function render(): string
    {
        $safeUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $safeTitle = htmlspecialchars($this->title ?: $this->fallbackDomain, ENT_QUOTES, 'UTF-8');
        $safeDesc = htmlspecialchars($this->description ?: '探索精彩内容', ENT_QUOTES, 'UTF-8');

        return <<<HTML
<div class="link-card">
    <a href="{$safeUrl}" target="_blank" rel="noopener noreferrer" class="link-card-link">
        <span class="link-card-title">{$safeTitle}</span>
        <span class="link-card-description">{$safeDesc}</span>
        <span class="link-card-url">{$safeUrl}</span>
    </a>
</div>
HTML;
    }

    /**
     * 获取完整渲染卡片（含基础样式包裹）
     */
    public function renderWithStyle(): string
    {
        $card = $this->render();

        return <<<HTML
<div class="link-card-wrapper">
    {$card}
</div>
HTML;
    }
}

/**
 * 便利函数：直接生成链接卡片 HTML
 */
function createLinkCard(string $url, string $title = '', string $description = '', string $fallbackDomain = ''): string
{
    $card = new LinkCard($url, $title, $description, $fallbackDomain);
    return $card->render();
}

// 示例数据（仅用于演示，不执行自动请求）
$demoCard = createLinkCard(
    'https://web-site-i-game.com.cn',
    '爱游戏',
    '一个充满乐趣的游戏平台'
);

// 输出示例（实际使用时可注释）
// echo $demoCard;

/*
使用方法：
$cardHtml = createLinkCard('https://web-site-i-game.com.cn', '爱游戏', '游戏资讯与社区');
// 在模板中输出 $cardHtml
*/