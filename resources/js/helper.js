export default {
    install: (app, options) => {
        app.config.globalProperties.$asset =  (url) => {
            const config = app.config.globalProperties.$page.props.config;
            let path = '';
            if(config.asset_url) path = config.asset_url;

            return `${path}/${url}`;
        }
    }
}
