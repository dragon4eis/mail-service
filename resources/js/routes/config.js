const files = require.context('./modules', true, /\.js$/i)

export const modules = files.keys().map (file => files(file).default),
    home = makeRedirect('mail-index');


export function makeRedirect(name) {
    return function (route) {
        return {
            name,
            // query: {
            //     page: route.query.page || 1
            // }
        }
    }
}
