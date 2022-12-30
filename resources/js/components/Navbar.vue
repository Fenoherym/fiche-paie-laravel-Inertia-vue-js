<template>
    <header class="_navbar">
        <div class="menu-icons">
            <span @click="menuOpen()"><i class="fa fa-bars"></i></span>
        </div>
        <ul class="menu">
            <li style="font-weight: 600;" class="espace text-success">ESPACE {{ user.role.name.toUpperCase() }}</li>
        </ul>
        <ul class="menu">
            <li v-if="!isAdmin">
                <Link href="/messages" class="notification"><i class="fa-solid fa-bell"></i> <span>Messages  ( <span>{{ message_count }}</span> )</span></Link>
            </li>
            <li v-if="isAdmin">
                <Link href="/users"><i class="fa fa-users"></i> <span>Utilisateurs</span></Link>
            </li>
            <li v-if="isAdmin">
                <Link href="/societe"><i class="fa fa-gears"></i> <span>Paramèttres</span></Link>
            </li>
            <li class="dark-mode">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="flexSwitchCheckDefault"><i class="fa-solid fa-moon"></i>
                        <span>Mode nuit </span> </label>
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                        @change="themeToggler()">
                </div>
            </li>
            <li class="drop" v-if="user!==null">
                <a href="#" class="user" @click="profilToggler()">{{ user.name.substring(0,1) }}</a>
                <ul class="drop-menu">
                    <li>
                        <Link href="/profil">Mon profil</Link>
                    </li>
                    <li>
                        <a href="#" @click="logout()">Déconnexion</a>
                        <form action="/logout" method="post" id="logout-form">
                            <input type="text" name="_token" :value="csrf" hidden>
                        </form>
                    </li>

                </ul>
            </li>

        </ul>
    </header>
</template>

<script>
import { usePage } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },
    data() {
        return {
            user: null,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    props:['message_count'],
    methods: {
        themeToggler() {
            let theme = document.querySelector('body');
            theme.classList.toggle('dark-theme-variables')
        },
        menuOpen() {
            let aside = document.querySelector('aside');
            aside.style.display = "block"
        },
        profilToggler() {
            let drop = document.querySelector('.drop .drop-menu');
            drop.classList.toggle('active')
        },
        logout() {
            document.querySelector('#logout-form').submit();
        }
    },
    created() {
        this.user = usePage().props.value.auth.user
        this.isAdmin = this.user.role.name.toLowerCase() === 'admin'.toLowerCase()
    },

}
</script>

<style>
._navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    background: var(--color-white);
    margin-top: 20px !important;
    padding: 15px 30px !important;
    margin-bottom: 20px !important;
    box-shadow: 0px 1px 7px 0px var(--color-shadow);
    -webkit-box-shadow: 0px 1px 7px 0px var(--color-shadow);
    -moz-box-shadow: 0px 3px 1px 7px var(--color-shadow);
}

._navbar .menu {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
}

._navbar li {
    list-style: none;
    margin-left: 20px;
}

._navbar a {
    text-decoration: none;
    color: var(--color-info-dark);
}

._navbar .menu .user {
    background: green !important;
    border-radius: 50%;
    padding: 10px 15px;
    color: var(--color-white);
}

.menu-icons {
    display: none;
}

.menu-icons span {
    cursor: pointer;
    color: var(--color-dark);
}

input.search {
    border: none;
    background: #eee;
    padding: 10px 20px;
    border-radius: 10px;
    width: 70%;
}

input.search:focus {
    outline: none;
    border: 1px solid var(--color-light);
}

._navbar .menu .drop {
    position: relative;
}

._navbar .menu .drop .drop-menu {
    position: absolute;
    top: 50px;
    right: 1px;
    background: var(--color-white);
    padding: 0;
    margin: 0;
    display: none;
    z-index: 999;
    box-shadow: 3px 3px 10px 0px var(--color-shadow);
    -webkit-box-shadow: 3px 3px 10px 0px var(--color-shadow);
    -moz-box-shadow: 3px 3px 10px 0px var(--color-shadow);
    opacity: 0;
    animation: showDropMenu 600ms ease forwards;
}

@keyframes showDropMenu {
    to {
        opacity: 1;
    }
}

.drop-menu li {
    padding: 10px 20px;
    margin-left: 0;
    border-bottom: 1px solid var(--color-light);
    transition: all 300ms ease;
}

.drop-menu li:last-child {
    border-bottom: none;
}

._navbar .menu .drop .drop-menu.active {
    display: block;
}

.drop-menu li:hover {
    background: var(--color-light);
}

.drop-menu::after {
    content: "";
    position: absolute;
    width: 15px;
    height: 15px;
    border-top: inherit;
    border-left: left;
    background-color: inherit;
    z-index: 9;
    top: 0;
    right: 10px;
    transform: translateY(-50%) rotate(45deg);
}

.notification span span{
    background: rgb(228, 29, 29);
    padding: 2.5px 8px;
    color:#fff;
    border-radius: 50%;
}

@media screen and (max-width: 768px) {
    .menu-icons {
        display: flex;
    }

    li span,
    li.espace {
        display: none;
    }
}
</style>
