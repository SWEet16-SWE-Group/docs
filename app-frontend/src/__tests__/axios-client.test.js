import axiosClient from '../axios-client.js';
import MockAdapter from 'axios-mock-adapter';

describe('axiosClient', () => {
    let mock;

    beforeEach(() => {
        mock = new MockAdapter(axiosClient);
        localStorage.setItem('ACCESS_TOKEN', 'test_token');
    });

    afterEach(() => {
        mock.reset();
        localStorage.clear();
    });

    it('should include Authorization header in requests', async () => {
        mock.onGet('/test').reply(200, { data: 'response' });

        const response = await axiosClient.get('/test');

        expect(response.config.headers.Authorization).toBe('Bearer test_token');
    });

    it('should remove token and reload on 401 response', async () => {
        mock.onGet('/test').reply(401);

        try {
            await axiosClient.get('/test');
        } catch (error) {
            expect(localStorage.getItem('ACCESS_TOKEN')).toBeNull();
        }
    });

    it('should pass through 404 response', async () => {
        mock.onGet('/test').reply(404);

        try {
            await axiosClient.get('/test');
        } catch (error) {
            expect(error.response.status).toBe(404);
        }
    });

    it('should pass through successful response', async () => {
        mock.onGet('/test').reply(200, { data: 'response' });

        const response = await axiosClient.get('/test');

        expect(response.data).toEqual({ data: 'response' });
    });
});
