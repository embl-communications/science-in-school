# Order for postprocessing

1.Before: Import JSON-files for ACF fields, SIS Template activated, Tooltype and migration plugins disabled,
        redirection plugin activated, Settings for WPML: translations activated for sis-articles, Languages imported

2.
postprocess.sh

3.
php postprocess-terms-issues.php

4.
php postprocess-terms-articles.php

5.
php postprocess-images-and-files.php

6.
php postprocess-images-and-files-materials.php

7.
postprocess-translations.sh

8.
php postprocess-urls.php
