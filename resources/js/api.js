import axios from 'axios'

export function getDocList(id) {
    id = id || 0;
    return axios({
        method: 'post',
        url: '/folder',
        data: {
            id
        },
    })
}