import axios from 'axios'

export function getDocList(id) {
    id = id || 0;
    return axios({
        method: 'post',
        url: id === 0 ? '/folder' : 'folder/' + id,
    })
}

export function newDoc(data) {
    return axios({
        method: 'post',
        url: '/draftDocs',
        data
    })
}

export function moveDoc(srcId, destId) {
    const data = { dest: destId }
    return axios({
      url: '/draftDocs/' + srcId + '/move',
      method: 'put',
      data
    })
}

export function delDoc(id) {
    return axios({
        method: 'delete',
        url: '/draftDocs/' + id,
    })
}

export function getCategoryList() {
    return axios({
        method: 'get',
        url: '/userCategories',
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
    return axios({
      url: '/categories/' + srcId + '/move',
      method: 'put',
      data
    })
}