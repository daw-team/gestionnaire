<template>
  <div
    class="side-bar"
    :class="{'desactivate-menu': !menuActive}"
    @mouseover="toggleMenu(false)"
    @mouseleave="toggleMenu(true)"
  >
    <ion-icon   name="menu"   class="menu-icon" @click="toggleMenu(menuActive)"></ion-icon>
    <div class="menu-title">
        <transition name="appear">
            <h1 v-if="menuActive">{{ activeTitle }}</h1>
        </transition>
    </div>

    <ul id="menu-list"  >
        <router-link
            v-for="(list, index) in menu"
            :key="index"
            :to="list.link">
        <li
        :class="{ active: list.active }"
        @click="changelist(list.name)"
        >
            <div>
                <ion-icon
                :name="list.icon"
                :class="{ activeIcon: list.active }"
                ></ion-icon>
                <transition name="appear">
                    <span   v-if="menuActive">{{ list.title }}</span>
                </transition>
            </div>
        </li>
        </router-link>
        <a  href="/logout"  class="logout-btn" v-if="menuActive">
            <li>
                <ion-icon name="log-out-outline">
                </ion-icon>
                <transition name="appear">
                    <span  >Logout</span>
                </transition>
            </li>
        </a>
    </ul>
  </div>
</template>

<script>
import bus from '../../EventBus'

export default {
  name: "StSideBar",
  components: {},
  data() {
    return {
      list: "",
      userId: this.$route.params.id,
      menu: [
        { title: "Home", icon: "home", link: `/student=${this.$route.params.id}/dashboard/home`, active: false, name: 'StHome' },
        { title: "My profile", icon: "person", link: `/student=${this.$route.params.id}/dashboard/profile`, active: false, name: 'StProfile' },
        { title: "My absences", icon: "clipboard", link: `/student=${this.$route.params.id}/dashboard/absences`, active: false, name: 'StAbsences' },
        { title: "My modules", icon: "albums", link: `/student=${this.$route.params.id}/dashboard/modules`, active: false, name: 'StModules' },
      ],
      links:[

      ],
      menuActive: false,
      activeTitle: '',
    };
  },


  methods: {
    toggleMenu(bool) {
        this.menuActive = !bool
        bus.$emit('changeMenu', this.menuActive);
    },



    changelist(name) {
      this.menu.forEach((element) => {
        if (element.name === name) {
            element.active = true
            this.activeTitle = element.title
        }
        else    element.active = false;
      });
    },

  },

  mounted() {
    const hr = document.createElement("hr");
    hr.style.margin = '20px 20px'
    this.list = document.querySelector("#menu-list");
    this.list.children[1].after(hr);
    this.changelist(this.$route.name);
  },
};
</script>


<style scoped>
.appear-enter{
    opacity: 0;
}

.appear-enter-active{
    transition: opacity 1s;
}


#menu-list div{
    margin-left: 8px;
}

.side-bar {
  width: 260px;
  height: 100vh;
  padding: 30px 0 30px 0;
  background: linear-gradient(180deg, #008828, #305748, #305748,#305748,  #305748, #305748, #008828);
  position: fixed;
  top: 0;
  left: 0;
  color: #fff;
  transition: all ease .4s;
}

.desactivate-menu{
    width: 70px;
    transition: all ease .4s;
}

a{
    text-decoration: none;
}

a:visited{
    text-decoration: none;
    color: #fff;
}

.menu-title{
    padding-left: 30px;
    height: 120px;
  font-size: 15px;
  text-align: center;
  font-weight: 700;
}


.borders-after {
  border-radius: 0 15px 0 0 !important;
}

.borders-before {
  border-radius: 0 0 15px 0 !important;
}

li {
  height: 100px;
  font-size: 18px;
  font-weight: 600;
  width: 100%;
  display: flex;
  align-content: space-between;
  cursor: pointer;
  flex-direction: row;
  flex-wrap: wrap;
}

li div {
    display: flex;
    flex-direction: row;
    align-items: center;
    height: 50px;
}

li::before{
    content: '';
    width: 100%;
    height: 15px;
    /* background: linear-gradient(-90deg, #2c4eb4, #2c4eb4,  #3E7E3F); */
  background-color: #305748;

    border-bottom-right-radius: 15px;
}

li::after{
    content: '';
    width: 100%;
    height: 15px;
    /* background: linear-gradient(-90deg, #2c4eb4,#2c4eb4, #3E7E3F); */
  background-color: #305748;

    border-top-right-radius: 15px;


}

li span {
  margin-left: 30px;
  opacity: 1;

}

.active {
  background-color: #fff;
  color: #2c4eb4;
  border-radius: 50px 0 0 50px;
}

.activeIcon {
  color: #2c4eb4 !important;
}

ion-icon {
  margin-left: 10px;
  font-size: 35px;
  color: #fff;
  visibility: visible;
  min-width: 40px;
}

.logout-btn{
    margin: 1px;
}

.logout-btn li::after{
    content: none;
    width: 0;
    height: 0;
}

.logout-btn li::before{
    content: none;
    width: 0;
    height: 0;
}
</style>
