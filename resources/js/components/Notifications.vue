<template>
    <div class="dropdown nav-item main-header-notification">
        <a class="new nav-link" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="header-icon-svgs feather feather-bell">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="pulse" v-if="unreadCount > 0"></span>
        </a>
        <div class="dropdown-menu">
            <div class="menu-header-content bg-primary text-right">
                <div class="d-flex">
                    <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الإشعارات</h6>
                    <span class="badge badge-pill badge-warning mr-auto my-auto float-left">{{unreadCount}} إشعارات غير مقروءة</span>
                </div>
            </div>
            <div class="main-notification-list Notification-scroll" style="overflow: auto;">
                <a class="d-flex p-3 border-bottom" :href="item.data.url" v-for="item in unread" :key="item.id" @click="readNotifications(item)">
                    <div class="notifyimg bg-pink avatar avatar-xs rounded-circle text-capitalize">
                        {{item.data.image}}
                    </div>
                    <div class="mr-3">
                        <h5 class="notification-label mb-1">{{item.data.message}}</h5>
                        <div class="notification-subtext">{{item.data.created_at}}</div>
                    </div>
                    <div class="mr-auto" >
                        <i class="las la-angle-left text-left text-muted"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                read: {},
                unread: {},
                unreadCount: 0,
            }
        },
        created: function () {
            this.getNotifications();
            let userId = $('meta[name="userId"]').attr('content');
            Echo.private('App.User.' + userId)
                .notification((notification) => {
                    this.unread.unshift(notification);
                    this.unreadCount++;
                });
        },
        methods: {
            getNotifications() {
                axios.get('/dashboard/user/notifications/get').then(res => {
                  this.read = res.data.read;
                  this.unread = res.data.unread;
                  this.unreadCount = res.data.unread.length;
              }).catch(error => Exception.handle(error));
            },
            readNotifications(notification) {
                axios.post('/dashboard/user/notifications/read', {id: notification.id}).then(res => {
                    this.unread.splice(notification,1);
                    this.read.push(notification);
                    this.unreadCount--;
                });
            }
        }
    }
</script>
