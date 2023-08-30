const septembedCurrentScript = document.currentScript
const septembedUrlParams = new URLSearchParams(septembedCurrentScript.src.split('.js')[1])
const septembedParams = Object.fromEntries(septembedUrlParams.entries())

const septembedStylesheet = `
.sj-container {
    padding:10px;
    border-radius:20px;
    display:block;
    text-decoration:none;
    transition: background 1s ease;
}

.sj-container:hover {
    background: #ffc000;
}

.sj-subtitle {
    font-size: 0.9em;
}
.sj-progress {
    font-size: 0.9em;
    box-sizing:border-box;
    padding-left:10px;
    height:100%;
    background:black;
    border-top-left-radius:15px;
    border-bottom-left-radius:15px;
    display:flex;
    align-items: center;
    color: white;
}

.sj-progress-text {
    position: absolute;
    top: 3px;
    right: 0;
    left: 5px;
    bottom: 0;
    color: white;
    text-align: left;
}
`

const septembedDarkMode = `
.sj-container {
    background:black;
    color:white;
    border: 2px solid white;
}
`

const septembedLightMode = `
.sj-container {
    background: #fddb73;
    color:black;
    border: 2px solid #ffc000;
}
`

const septembedThemes = {
    dark: septembedDarkMode,
    light: septembedLightMode
}

let vanity = null
let slug = null

if (septembedParams.u)
{
    const url = new URL(septembedParams.u)
    const parts = url.pathname.split('/').filter(p => p)
    vanity = parts[0]
    slug = parts[1]
}

const septembedPath = `https://septembed.rknight.me/sj.php?vanity=${vanity}&slug=${slug}`
fetch(septembedPath)
.then((response) => response.json())
.then((data) => {
    container = document.createElement('a')
    container.className = 'sj-container'
    container.href = data.url
    container.target = '_blank'

    title = document.createElement('p')
    title.className = 'sj-title'
    title.style = 'margin-top: 0;margin-bottom:5px;font-weight:bold'
    title.innerHTML = `${data.title}<br style="margin-bottom:5px;">`
    container.append(title)

    subtitle = document.createElement('p')
    subtitle.className = 'sj-subtitle'
    subtitle.style = 'margin-top: 0;margin-bottom:10px'
    subtitle.innerHTML = 'Raising money for St Jude Children\'s Research Hospital this September'
    container.append(subtitle)

    progressWrap = document.createElement('div')
    progressWrap.style = 'position:relative;height:25px;background:rgb(189, 195, 199, 0.6);border-radius:15px;'

    progress = document.createElement('div')
    progress.className = 'sj-progress'
    // progress.innerHTML = ` ${data.raised} &bull; ${data.percentage}%`
    progress.style = `width:${data.percentage}%;`

    progressText = document.createElement('div')
    progressText.className = 'sj-progress-text'
    progressText.innerHTML = ` ${data.raised} &bull; ${data.percentage}%`
    // progressText.style = `width:${data.percentage}%;`

    progressWrap.append(progress)
    progressWrap.append(progressText)
    container.append(progressWrap)

    styles = document.createElement('style')
    styles.innerHTML = septembedStylesheet
    styles.innerHTML += septembedThemes[data.mode]

    septembedCurrentScript.parentNode.insertBefore(styles, septembedCurrentScript)
    septembedCurrentScript.parentNode.insertBefore(container, septembedCurrentScript)
})
