function appendAnchorLinkData($elementId, $pageName)
{
    $links = $('#'+$elementId + ' li a');

    href = '';
    $links.each(function () {
        href = $(this).attr('href');
        $(this).attr('href', href + '#'+$pageName);
    });
}
