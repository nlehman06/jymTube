import {shallow, mount} from '../../node_modules/@vue/test-utils/dist/vue-test-utils';
import expect from 'expect';
import CheckUrl from '../../resources/assets/js/components/CheckUrlComponent.vue';
import moxios from 'moxios';

describe('CheckUrl', () => {
    let wrapper;

    let button;

    let urlData = {
        content_tags:  null,
        created_time:  "2018-03-26 14:30:00",
        custom_labels: null,
        description:   "It amazes me how many PRE-WORKOUTS on the market DON'T include BCAAs. Big mistake – BCAAs are just as important before a workout as after. In the below video, I explain why. If you want a pre-workout that includes a full 6-gram dose of BCAAs, get PRE JYM: PreJYM.com/bodybuilding.",
        from_id:       307812318023,
        from_name:     "Dr. Jim Stoppani",
        length:        236.981,
        permalink_url: "/JimStoppaniPhD/videos/10156310534098024/",
        picture:       "https://scontent.xx.fbcdn.net/v/t15.0-10/p168x128/27853565_10156310538823024_3994653089490534400_n.jpg?_nc_cat=0&oh=1a0c2cf5b4c9ea1fe13212069f795d1c&oe=5B27CFCD",
        provider:      "facebook",
        provider_id:   10156310534098024,
        title:         "Supplement Round-Up BCAA's",
    };

    beforeEach(() => {
        moxios.install(axios);
        wrapper = mount(CheckUrl);
        button = wrapper.find('#checkUrlButton');
    });

    afterEach(() => {
        moxios.uninstall(axios);
    });

    it('renders the correct title on the page', () => {
        expect(wrapper.html()).toContain('Enter the URL of the video');
    });

    it('changes the button text when checking', () => {
        expect(button.text()).toBe('Check URL');
        button.trigger('click');
        expect(button.text()).toBe('Checking...');
    });
/*
    it('checks the server for a valid url', (done) => {
        moxios.stubRequest('/api/addVideo/checkURL', {
            status:   200,
            response: [
                {
                    success:  true,
                    url_data: urlData
                }
            ]
        });

        let input = wrapper.find('#url');
        input.element.value = 'https://www.facebook.com/JimStoppaniPhD/videos/10156310534098024/';
        input.trigger('input');

        wrapper.find('#checkUrlButton').trigger('click');
        moxios.wait(() => {
            console.log(wrapper.vm.responseData);
            expect(wrapper.vm.responseData.urlData.title).toBe(urlData.title);
            done();
        })
    });

    it.only('broadcasts responseData after checking url', (done) => {

        moxios.stubRequest('/api/addVideo/checkURL', {
            status:   200,
            response: [
                {
                    success:  true,
                    url_data: urlData
                }
            ]
        });
        console.log(wrapper.emitted());
        button.trigger('click');
        console.log(wrapper.emitted());

        wrapper.find('#checkUrlButton').trigger('click');
        moxios.wait(() => {
            expect(wrapper.emitted().receiveResponse).toBeTruthy();
            done();
        });
    });*/
});