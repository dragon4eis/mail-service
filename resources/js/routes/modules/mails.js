import MailCreate from "../../components/Pages/MailCreate";
import MailPreview from "../../components/Pages/MailPreview";
import MailListPage from "../../components/MailListPage";
import {makeRedirect} from "../config";

const storeModule = 'mail';

export default {
    path: 'mail',
    name: `${storeModule}-index`,
    redirect: makeRedirect(`${storeModule}-create`),
    component: MailListPage,
    children:[
        {
            path: "create",
            name: `${storeModule}-create`,
            props: {
                default: true
            },
            components:{
                default: MailCreate
            }
        },
        {
            path: ':mail_id(\\d+)',
            name: `${storeModule}-select`,
            props: {
                default: true
            },
            components:{
                default: MailPreview
            }
        },
    ]
}
