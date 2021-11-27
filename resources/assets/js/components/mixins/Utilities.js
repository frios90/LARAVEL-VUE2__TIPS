
export default { 
    data () {
        return {
            loader: true,
            link_active: 'home',
            license_allowed: {
                user_allow: {
                    status: true
                },
                staff_allow: {
                    status: true
                },
                tip_work_allow: {
                    status: true
                }
            }
        }
    },    
    mounted () {
        this.licenseAllowed()            
    }, 
    methods: {
        go (url, link) {
            this.$router.push({path: url})
            if (link) {
                this.link_active = link
                var data = {
                    link : link,  
                }
                localStorage.setItem("current_page", JSON.stringify(data))
            }            
        },
        licenseAllowed () {
            var self = this
            this.$http.get('/license-allowed').then(function(response) {
                self.license_allowed = response.body
            }, function() {
                this.$toasted.global.APP_GENERAR_ERROR()
            })
        },
        changeLink (link) {
            this.link_active = link
            var data = {
                link : link,  
            }
            localStorage.setItem("current_page", JSON.stringify(data))
        }

    }
}