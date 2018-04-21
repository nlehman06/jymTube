import {mount, shallow} from '../../node_modules/@vue/test-utils/dist/vue-test-utils';
import expect from 'expect';
import AddVideo from '../../resources/assets/js/components/AddVideoComponent';
import CheckUrl from '../../resources/assets/js/components/CheckUrlComponent.vue';
import FoundVideoFromUrl from '../../resources/assets/js/components/FoundVideoFromUrlComponent.vue';
import UrlNotFound from '../../resources/assets/js/components/UrlNotFoundComponent.vue';
import moxios from 'moxios';


describe('AddVideo', () => {
    let wrapper, button;
    const urlData = {
        title:        'Some Title',
        create_at:    '2018-04-16 00:00:00',
        provider:     'facebook',
        picture:      '',
        description:  '',
        from_profile: '',
        from_name:    '',
    };

    beforeEach(() => {
        moxios.install(axios);

        wrapper = mount(AddVideo, {
            stubs: {
                CheckUrl:          CheckUrl,
                FoundVideoFromUrl: FoundVideoFromUrl,
                UrlNotFound:       UrlNotFound
            }
        });

        button = wrapper.find('#checkUrlButton');
    });

    afterEach(() => {
        moxios.uninstall(axios);
    });

    it('shows the initial instruction title', () => {
        expect(wrapper.html()).toContain('Enter the URL of the video');
    });

    it('changes the button text when checking', () => {
        expect(button.text()).toBe('Check URL');
        button.trigger('click');
        expect(button.text()).toBe('Checking...');
    });

    it('shows a confirmation card when it finds a valid url', (done) => {

        moxios.stubRequest('/api/addVideo/checkURL', {
            status:   200,
            response: {
                success:  true,
                url_data: urlData
            }
        });

        button.trigger('click');

        moxios.wait(() => {
            expect(wrapper.html()).toContain('Some Title');
            done();
        })
    });

    it('shows an error card when it cannot find a valid url', (done) => {
        moxios.stubRequest('/api/addVideo/checkURL', {
            status:   302,
            response: {
                success:    false,
                error_data: {
                    message:               "We couldn't find this video on Facebook",
                    message_from_provider: "Error message from provider",
                    other_info:            "No id found"
                }
            }
        });

        button.trigger('click');

        moxios.wait(() => {
            expect(wrapper.html()).toContain("We couldn't find this video on Facebook");
            expect(wrapper.html()).toContain("Error message from provider");
            expect(wrapper.html()).toContain("No id found");
            done();
        })
    });

    it.only('allows the user to submit a found video for review', (done) => {

        wrapper.vm.responseData.urlData = {
            content_tags:  null,
            created_time:  "2018-03-26 14:30:00",
            custom_labels: null,
            description:   "It amazes me how many PRE-WORKOUTS on the market DON'T include BCAAs. Big mistake – BCAAs are just as important before a workout as after. In the below video, I explain why. If you want a pre-workout that includes a full 6-gram dose of BCAAs, get PRE JYM: PreJYM.com/bodybuilding.",
            from_id:       "307812318023",
            from_name:     "Dr. Jim Stoppani",
            from_profile:  "https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/19756356_10155548622063024_7364227892948231468_n.jpg?_nc_cat=0&oh=142378781fd047c119953edace46cd0a&oe=5B521D97",
            length:        236.981,
            permalink_url: "/JimStoppaniPhD/videos/10156310534098024/",
            picture:       "https://scontent.xx.fbcdn.net/v/t15.0-10/p168x128/27853565_10156310538823024_3994653089490534400_n.jpg?_nc_cat=0&oh=945a19d1fe4d0a86d7753f2ab8d08ee5&oe=5B4F5CCD",
            provider:      "facebook",
            provider_id:   "10156310534098024",
            title:         "Supplement Round-Up BCAA's"
        };

        expect(wrapper.contains('#submitVideoForReviewButton')).toBe(true);

        moxios.stubRequest('/api/addVideo', {
            status:   201,
            response: {}
        });

        const submitForReviewButton = wrapper.find('#submitVideoForReviewButton');
        submitForReviewButton.trigger('click');

        moxios.wait(() => {
            expect(wrapper.html()).toContain('Thank you for your help in adding mass to Jym Tube!');
            expect(wrapper.contains('#submitForReviewButton')).toBe(false);
            expect(wrapper.contains('#continueToHome')).toBe(true);
            done();
        })
    });
});