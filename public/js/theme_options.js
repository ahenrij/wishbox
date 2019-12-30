var themeOptions = {
    "Theme1": {
            '--primary-color': '#181818',
            '--secondary-color': '#282828',
            '--text-primary': '#1db954',
            '--text-secondary': '#666666',
            '--text-and-border': 'red',
            '--checkboxes': '#b3b3b3',
            '--gallery': '#b3b3b3',
            '--bubba-figure-effect': '#b3b3b3',
            '--bubba-border': '#b3b3b3',
        },
    "Theme2": {
            '--primary-color': '#181818',
            '--secondary-color': '#282828',
            '--text-primary': '#1db954',
            '--text-secondary': '#666666',
            '--text-and-border': 'yellow',
            '--checkboxes': '#b3b3b3',
            '--gallery': '#b3b3b3',
            '--bubba-figure-effect': '#b3b3b3',
            '--bubba-border': '#b3b3b3',
        },
    "Theme3": {
            '--primary-color': '#181818',
            '--secondary-color': '#282828',
            '--text-primary': '#1db954',
            '--text-secondary': '#666666',
            '--text-and-border': 'green',
            '--checkboxes': '#b3b3b3',
            '--gallery': '#b3b3b3',
            '--bubba-figure-effect': '#b3b3b3',
            '--bubba-border': '#b3b3b3',
        }
};


function applyTheme(selectedTheme, html) {
        // Iterate through each propriety and assign new value to html document
        // keys are variable
        $.each(selectedTheme, function(key, value){
                // console.log(key + " " + value + " ; ");
                html.style.setProperty(key, selectedTheme[key]);
        });
}