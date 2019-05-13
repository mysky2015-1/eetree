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

export function newDoc() {
    return axios({
        method: 'post',
        url: '/draftDocs',
    })
}

export function delDoc(id) {
    return axios({
        method: 'delete',
        url: '/draftDocs/' + id,
        data,
    })
}

export function newCategory(data) {
    return axios({
        method: 'post',
        url: '/categories',
        data,
    })
}

export function editCategory(id, data) {
    return axios({
        method: 'put',
        url: '/categories/' + id,
        data,
    })
}

export function delCategory(id) {
    return axios({
        method: 'delete',
        url: '/categories/' + id,
    })
}

export function moveCategory(srcId, destId) {
    const data = { dest: destId }
    return request({
      url: '/categories/' + srcId + '/move',
      method: 'put',
      data
    })
  }