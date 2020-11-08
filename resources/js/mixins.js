export const mail_preview = {
    computed: {
        status() {
            switch (this.mail.status) {
                case 1:
                    return {
                        'class': 'badge-info',
                        'label': 'created'
                    }
                case 2:
                    return {
                        'class': 'badge-warning',
                        'label': 'processing'
                    }
                case 3:
                    return {
                        'class': 'badge-danger',
                        'label': 'failed'
                    }
                case 4:
                    return {
                        'class': 'badge-success',
                        'label': 'send'
                    }
                default:
                    return {
                        'class': 'badge-light',
                        'label': 'unknown'
                    }
            }
        }
    }
}