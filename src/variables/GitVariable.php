<?php
/**
 * Output git info over twig
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2024, leowebguy
 */

namespace leowebguy\gitinfo\variables;

class GitVariable
{
    public function branch(): string
    {
        $head = file(CRAFT_BASE_PATH . '/.git/HEAD', FILE_USE_INCLUDE_PATH);
        $branch = explode('/', $head[0] ?? '', 3);
        return $branch[2] ?? 'empty branch';
    }

    public function remoteUrl()
    {
        $config = file_get_contents(CRAFT_BASE_PATH . '/.git/config');
        preg_match('/url[^\r\n]*/m', $config, $match);
        $url = explode('@', $match[0] ?? '');
        return $url[1] ?? 'empty remote url';
    }

    public function lastTag()
    {
        exec('git tag -l --sort=-creatordate | head -n 1', $output);
        return $output[0] ?? 'empty last tag';
    }

    public function commitHash()
    {
        exec('git rev-parse --verify HEAD 2> /dev/null', $output);
        return $output[0] ?? 'empty commit hash';
    }

    public function commitAuthor()
    {
        //exec('git log -1 --format="%an | %ae"', $output); // name and email
        exec('git log -1 --format="%an"', $output);
        return $output[0] ?? 'empty last log';
    }

    public function commitDate()
    {
        exec('git log -1 --format="%at" | xargs -I{} date -d @{} +%Y/%m/%d\ %H:%M:%S', $output);
        return $output[0] ?? 'empty last log';
    }
}
