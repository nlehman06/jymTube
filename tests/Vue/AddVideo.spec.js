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
});