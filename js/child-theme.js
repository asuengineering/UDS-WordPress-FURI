// Start your project's JS here.
// If you are rolling some jQuery you'll want to use a doc ready statement like the following.

jQuery(document).ready(function ($) {
    // Logic for maniuplating content within single-participant.php
    if ($('body').hasClass('single-participant')) {
        $('.project-icon').detach().appendTo('#project-icon-column');
    }
});
