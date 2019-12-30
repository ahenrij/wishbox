var themeOptions = {
    "Theme1": {
            '--primary-color': '#007bff',
            '--secondary-color': '#282828',
            '--text-primary': '#5f6061',
            '--text-secondary': '#666666',
            '--text-and-border': '#98999a',
            '--checkboxes': '#b3b3b3',
            '--gallery': '#b3b3b3',
            '--bubba-figure-effect': '#b3b3b3',
            '--bubba-border': '#b3b3b3',
        },
    "Theme2": {
            '--primary-color': '#7B0D1E',
            '--secondary-color': '#9F2042',
            '--text-primary': '#3D1308',
            '--text-secondary': '#666666',
            '--text-and-border': '#211103',
            '--checkboxes': '#b3b3b3',
            '--gallery': '#b3b3b3',
            '--bubba-figure-effect': '#7B0D1E',
            '--bubba-border': '#b3b3b3',
        },
    "Theme3": {
            '--primary-color': '#FFA987',
            '--secondary-color': '#FFFC31',
            '--text-primary': '#E94F37',
            '--text-secondary': '#666666',
            '--text-and-border': '#393E41',
            '--checkboxes': '#b3b3b3',
            '--gallery': '#b3b3b3',
            '--bubba-figure-effect': '#5C415D',
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
