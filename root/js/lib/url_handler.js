class UrlHandler {

    constructor(url = window.location.href) {

        const protocol = url.match(/^(.*?):\/\//);
        const host     = url.match(/^.*?:\/\/([^/?#]*)/);
        const hostname = url.match(/^.*?:\/\/([^/?#:]*)/);
        const port     = url.match(/^.*?:\/\/.*?:([^/?#]*)/);
        const pathname = url.match(/^.*?:\/\/.*?(\/[^?#]*)/);
        const search   = url.match(/^.*?:\/\/.*?(\?[^#]*)/);
        const hash     = url.match(/^.*?:\/\/.*?(#.*)/);

        this.href = url;
        this.protocol = protocol !== null ? protocol[1] : '';
        this.host = host !== null ? host[1] : '';
        this.hostname = hostname !== null ? hostname[1] : '';
        this.port = port !== null ? port[1] : '';
        this.pathname = pathname !== null ? pathname[1] : '';
        this.search = search !== null ? search[1] : '';
        this.hash = hash !== null ? hash[1] : '';

    }

    get pathnameLast() {
        return this.pathname.slice(-1) === '/' ? '/' : '';
    }

    get pathnames() {
        return this.pathname.replace(/^\//, '').replace(/\/$/, '').split('/');
    }

    get searches() {
        return this.search.replace(/^\?/, '').split('&').filter(item => {
            return item !== '';
        }).map(item => {
            const [name,
                value] = item.split('=');
            return {name, value};
        });
    }

    deleteSearch(name = null, value = null) {
        const url = `${this.protocol}://${this.hostname}:${this.port}`.replace(/:$/, '') + this.pathnames.reduce((total, item) => {
            return `${total}${item}/`;
        }, '/').replace(/\/+$/, this.pathnameLast) + this.searches.filter(item => {
            if (name === null) {
                return false;
            } else if (name !== null && value === null) {
                return item.name !== name;
            } else if (name !== null && value !== null) {
                return item.name !== name || item.value !== value
            } else {
                return true;
            }
        }).reduce((total, item) => {
            return `${total}${item.name}=${item.value}&`;
        }, '?').replace(/[?&]+$/, '') + this.hash.replace(/#$/, '');
        return new UrlHandler(url);
    }

    setSearch(name = '', value = '') {
        const url = `${this.protocol}://${this.hostname}:${this.port}`.replace(/:$/, '') + this.pathnames.reduce((total, item) => {
            return `${total}${item}/`;
        }, '/').replace(/\/+$/, this.pathnameLast) + this.searches.filter(item => {
            return item.name !== name;
        }).concat([{name, value}]).reduce((total, item) => {
            return `${total}${item.name}=${item.value}&`;
        }, '?').replace(/[?&]+$/, '') + this.hash.replace(/#$/, '');
        return new UrlHandler(url);
    }

    sortSearch(sortFunction = (itemA, itemB) => itemA.name < itemB.name ? -1 : 1) {
        const url = `${this.protocol}://${this.hostname}:${this.port}`.replace(/:$/, '') + this.pathnames.reduce((total, item) => {
            return `${total}${item}/`;
        }, '/').replace(/\/+$/, this.pathnameLast) + this.searches.sort(sortFunction).reduce((total, item) => {
            return `${total}${item.name}=${item.value}&`;
        }, '?').replace(/[?&]+$/, '') + this.hash.replace(/#$/, '');
        return new UrlHandler(url);
    }

    deleteHash() {
        const url = `${this.protocol}://${this.hostname}:${this.port}`.replace(/:$/, '') + this.pathnames.reduce((total, item) => {
            return `${total}${item}/`;
        }, '/').replace(/\/+$/, this.pathnameLast) + this.searches.reduce((total, item) => {
            return `${total}${item.name}=${item.value}&`;
        }, '?').replace(/[?&]+$/, '');
        return new UrlHandler(url);
    }

    setHash(value = '') {
        const url = `${this.protocol}://${this.hostname}:${this.port}`.replace(/:$/, '') + this.pathnames.reduce((total, item) => {
            return `${total}${item}/`;
        }, '/').replace(/\/+$/, this.pathnameLast) + this.searches.reduce((total, item) => {
            return `${total}${item.name}=${item.value}&`;
        }, '?').replace(/[?&]+$/, '') + `#${value}`;
        return new UrlHandler(url);
    }

}
