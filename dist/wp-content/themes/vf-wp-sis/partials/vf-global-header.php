<header class="vf-global-header">
    <a href="/" class="vf-logo">
        <img class="vf-logo__image"
             src="/wp-content/themes/vf-wp-sis/assets/images/logo/scienceInSchool_logo.png"
             alt="Science in School" loading="eager">
    </a>
    <nav class="vf-navigation vf-navigation--global vf-cluster">
        <ul class="vf-navigation__list | vf-list--inline | vf-cluster__inner">
            <li class="vf-navigation__item">
                <a href="/contact" class="vf-navigation__link">Contact</a>
            </li>
            <li class="vf-navigation__item">
                <a href="/newsletter" class="vf-navigation__link">Newsletter</a>
            </li>
            <li class="vf-navigation__item">
                <a href="/search" class="vf-navigation__link">Search</a>
            </li>
        </ul>
    </nav>
    <!-- Language Switcher -->
    <div class="vf-language-switcher">
        <button class="vf-language-switcher__button" aria-haspopup="true" aria-expanded="false">
            <img id="current-language-flag" 
                 src="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png" 
                 alt="English Flag" class="vf-language-switcher__flag">
        </button>
        <ul class="vf-language-switcher__dropdown">
            <li>
                <a href="/de/lang-de" data-lang="de" data-flag="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png" class="vf-language-switcher__option">
                    <img src="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/de.png" alt="German Flag" class="vf-language-switcher__flag">
                </a>
            </li>
            <li>
                <a href="/" data-lang="en" data-flag="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png" class="vf-language-switcher__option">
                    <img src="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png" alt="English Flag" class="vf-language-switcher__flag">
                </a>
            </li>
            <li>
                <a href="/fr/lang" data-lang="fr" data-flag="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/fr.png" class="vf-language-switcher__option">
                    <img src="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/fr.png" alt="French Flag" class="vf-language-switcher__flag">
                </a>
            </li>
            <li>
                <a href="/es/lang" data-lang="es" data-flag="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png" class="vf-language-switcher__option">
                    <img src="http://scienceinschool.org/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png" alt="Spanish Flag" class="vf-language-switcher__flag">
                </a>
            </li>
        </ul>
    </div>
</header>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const currentLangFlag = document.getElementById('current-language-flag');
    const dropdownOptions = document.querySelectorAll('.vf-language-switcher__option');
    const switcherButton = document.querySelector('.vf-language-switcher__button');
    const switcher = document.querySelector('.vf-language-switcher');

    // Detect the current language dynamically based on the URL or a `lang` attribute
    const currentLang = window.location.pathname.split('/')[1] || 'en'; // Default to English if no language in URL

    dropdownOptions.forEach(option => {
        const lang = option.dataset.lang;
        const flag = option.dataset.flag;

        if (lang === currentLang) {
            // Update the button to show the current language flag
            currentLangFlag.src = flag;
            currentLangFlag.alt = `${lang} Flag`;

            // Remove the current language from the dropdown
            option.parentElement.remove();
        }
    });

    // Toggle the dropdown visibility
    switcherButton.addEventListener('click', () => {
        const expanded = switcherButton.getAttribute('aria-expanded') === 'true' || false;
        switcherButton.setAttribute('aria-expanded', !expanded);
        switcher.classList.toggle('vf-language-switcher--active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!switcher.contains(event.target)) {
            switcherButton.setAttribute('aria-expanded', false);
            switcher.classList.remove('vf-language-switcher--active');
        }
    });
});


</script>