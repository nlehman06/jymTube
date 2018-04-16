import {mount, shallow} from '../../node_modules/@vue/test-utils/dist/vue-test-utils';
import expect from 'expect';
import AddVideo from '../../resources/assets/js/components/AddVideoComponent';
import CheckUrl from '../../resources/assets/js/components/CheckUrlComponent.vue';
import FoundVideoFromUrl from '../../resources/assets/js/components/FoundVideoFromUrlComponent.vue';
import moxios from 'moxios';


describe('AddVideo', () => {
    let wrapper, button;

    beforeEach(() => {
        moxios.install(axios);

        wrapper = mount(AddVideo, {
            stubs: {
                CheckUrl:          CheckUrl,
                FoundVideoFromUrl: FoundVideoFromUrl
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

        console.log(wrapper.html());
        let button = wrapper.find('button');

        moxios.stubRequest('/api/addVideo/checkURL', {
            status:   200,
            response: {
                urlData: {
                    title: 'Some Title'
                }
            }
        });

        button.trigger('click');

        moxios.wait(() => {
            console.log(wrapper.vm.responseData);
            expect(wrapper.html()).toContain('Some Title');
            done();
        })
    });
});