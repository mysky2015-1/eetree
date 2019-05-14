<template>
  <div class="row">
    <div class="col-md-12 top-bar">
      <router-link
        v-if="categoryId !== 0"
        tag="b-button"
        :to="{path: parentId === 0 ? '/doc/list/' : '/doc/list/' + parentId}"
      >&lt;&lt; 上一级</router-link>
      <b-button @click="newCategory">
        <i class="fa fa-folder-open-o" aria-hidden="true"></i>新建文件夹
      </b-button>
      <b-button @click="newDoc">
        <i class="fa fa-file-code-o" aria-hidden="true"></i>新建文档
      </b-button>
    </div>
    <div class="col-md-2 panel-left">
      <div class="panel-heading panel-heading-current">
        <i class="fa fa-home" aria-hidden="true"></i>我的文档
      </div>
      <div class="panel-heading">
        <i class="fa fa-share-alt" aria-hidden="true"></i>我的分享
      </div>
    </div>
    <div class="col-md-10 clearpadding">
      <div class="panel panel-default">
        <ul class="list-group clearpadding">
          <li class="list-group-item" v-for="row in categories" :key="'c' + row.id">
            <router-link :to="{path:'/doc/list/' + row.id}">{{ row.name }}</router-link>
            <b-button class="float-right" @click="showMove(row, 'category')">移动到</b-button>
            <b-button class="float-right" @click="editCategory(row)">重命名</b-button>
            <b-button class="float-right" @click="delCategory(row)">删除</b-button>
          </li>
          <li class="list-group-item" v-for="row in docs" :key="'d' + row.id">
            <a v-if="row.status != 1" :href="'/doc/edit/' + row.id">{{ row.title }}</a>
            <span v-if="row.status == 1">{{ row.title }}</span>
            <span class="created-time">{{ row.created_at }}</span>
            <a
              class="btn float-right btn-secondary"
              v-if="row.doc_id !== 0"
              :href="'/doc/detail/' + row.doc_id"
            >查看</a>
            <b-button class="float-right" @click="showMove(row, 'doc')">移动到</b-button>
            <b-button class="float-right" @click="delDoc(row)">删除</b-button>
          </li>
        </ul>
        <div
          class="modal fade"
          id="categoryModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="categoryModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5
                  class="modal-title"
                  id="categoryModalLabel"
                >{{ dialogType==='new'?'新建文件夹':'重命名' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input
                  ref="categoryName"
                  id="categoryName"
                  class="form-control"
                  v-model="category.name"
                  @focus="focusCategoryName($event)"
                  required
                >
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" @click="submitCategory">提交</button>
              </div>
            </div>
          </div>
        </div>
        <b-modal ref="move-modal" title="移动到" @ok="doMove()">
          <ul class="list-group">
            <xy-folder :list="moveCategories" @nodeClick="selectDestCategory"></xy-folder>
          </ul>
        </b-modal>
      </div>
    </div>
  </div>
</template>
<script>
var defaultCategory = {
  id: 0,
  name: '新建文件夹'
}
var modalFun = {
  show: function() {
    $('#categoryModal').on('shown.bs.modal', function(e) {
      $('#categoryName').focus()
    })
    $('#categoryModal').modal('show')
  },
  hide: function() {
    $('#categoryModal').modal('hide')
  }
}
import {
  getDocList,
  moveDoc,
  delDoc,
  newDoc,
  getCategoryList,
  newCategory,
  editCategory,
  delCategory,
  moveCategory
} from '../../js/api'
import { deepClone, unflatten } from '../../js/utils'
export default {
  data() {
    return {
      categoryId: parseInt(this.$route.params.id) || 0,
      parentId: 0,
      docs: [],
      moveCategories: [],
      categories: [],
      dialogType: 'new',
      category: Object.assign({}, defaultCategory),
      destCategoryId: 0,
      moveType: 'doc',
      moveItem: {}
    }
  },
  created() {
    this.getDocList()
  },
  methods: {
    getDocList() {
      getDocList(this.categoryId).then(res => {
        const data = res.data
        this.docs = data.data.docs
        this.categories = data.data.categories
        if (typeof data.data.category.parent_id !== 'undefined') {
          this.parentId = data.data.category.parent_id
        }
      })
    },
    newDoc() {
      newDoc({ user_category_id: this.categoryId }).then(res => {
        location.href = res.data.data.url
      })
    },
    delDoc(row) {
      this.$bvModal
        .msgBoxConfirm('确定该文档吗?', {
          okTitle: '确定',
          cancelTitle: '取消'
        })
        .then(confirmOk => {
          if (confirmOk === true) {
            delDoc(row.id).then(() => {
              this.$bvToast.toast('操作成功', {
                title: 'Success',
                variant: 'success'
              })
              for (let index = 0; index < this.docs.length; index++) {
                if (this.docs[index].id === row.id) {
                  this.docs.splice(index, 1)
                  break
                }
              }
            })
          }
        })
    },
    focusCategoryName(event) {
      event.currentTarget.select()
    },
    newCategory() {
      this.dialogType = 'new'
      this.category = Object.assign({}, defaultCategory)
      modalFun.show()
    },
    editCategory(row) {
      this.dialogType = 'edit'
      this.category = deepClone(row)
      modalFun.show()
    },
    submitCategory() {
      if (this.dialogType === 'new') {
        newCategory({
          name: this.category.name,
          parent_id: this.categoryId
        }).then(res => {
          this.$bvToast.toast('操作成功', {
            title: 'Success',
            variant: 'success'
          })
          this.category.id = res.data.data.id
          this.categories.push(this.category)
          modalFun.hide()
        })
      } else {
        editCategory(this.category.id, { name: this.category.name }).then(
          () => {
            this.$bvToast.toast('操作成功', {
              title: 'Success',
              variant: 'success'
            })
            for (let index = 0; index < this.categories.length; index++) {
              if (this.categories[index].id === this.category.id) {
                this.categories[index].name = this.category.name
                break
              }
            }
            modalFun.hide()
          }
        )
      }
    },
    delCategory(row) {
      this.$bvModal
        .msgBoxConfirm('确定要删除文件夹以及其中的文档吗?', {
          okTitle: '确定',
          cancelTitle: '取消'
        })
        .then(confirmOk => {
          if (confirmOk === true) {
            delCategory(row.id).then(() => {
              this.$bvToast.toast('操作成功', {
                title: 'Success',
                variant: 'success'
              })
              for (let index = 0; index < this.categories.length; index++) {
                if (this.categories[index].id === row.id) {
                  this.categories.splice(index, 1)
                  break
                }
              }
            })
          }
        })
    },
    showMove(row, moveType) {
      this.moveType = moveType
      this.moveItem = deepClone(row)
      getCategoryList().then(res => {
        res.data.data.forEach(element => {
          element.selected = false
        })
        let moveCategories = res.data.data
        if (moveType === 'category') {
          moveCategories = moveCategories.filter(category => {
            return category.id !== this.moveItem.id
          }, this)
        }
        this.moveCategories = [
          {
            id: 0,
            name: 'root',
            selected: false,
            children: unflatten(moveCategories)
          }
        ]
        this.$refs['move-modal'].show()
      })
    },
    selectDestCategory(row) {
      this.unselectCategory(this.moveCategories)
      row.selected = true
      this.destCategoryId = row.id
    },
    unselectCategory(items) {
      items.forEach(element => {
        element.selected = false
        if (
          typeof element.children !== 'undefined' &&
          element.children.length > 0
        ) {
          this.unselectCategory(element.children)
        }
      })
    },
    doMove() {
      if (this.moveType === 'doc') {
        if (this.categoryId === this.destCategoryId) {
          return false
        }
        moveDoc(this.moveItem.id, this.destCategoryId).then(() => {
          this.$bvToast.toast('操作成功', {
            title: 'Success',
            variant: 'success'
          })
          this.$router.push({
            path:
              this.destCategoryId === 0
                ? '/doc/list/'
                : '/doc/list/' + this.destCategoryId
          })
        })
      } else {
        if (
          this.moveItem.id === this.destCategoryId ||
          this.moveItem.parent_id === this.destCategoryId
        ) {
          return false
        }
        moveCategory(this.moveItem.id, this.destCategoryId).then(() => {
          this.$bvToast.toast('操作成功', {
            title: 'Success',
            variant: 'success'
          })
          // for (let index = 0; index < this.categories.length; index++) {
          //   if (this.categories[index].id === row.id) {
          //     this.categories.splice(index, 1)
          //     break
          //   }
          // }
          this.$router.push({
            path:
              this.destCategoryId === 0
                ? '/doc/list/'
                : '/doc/list/' + this.destCategoryId
          })
        })
      }
    }
  },
  watch: {
    $route(to, from) {
      this.$router.go(0)
    }
  }
}
</script>