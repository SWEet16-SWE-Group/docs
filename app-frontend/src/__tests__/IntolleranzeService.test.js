import '@testing-library/jest-dom/extend-expect';
import axiosClient from '../axios-client';
import { fetchAllergeni} from '../services/IntolleranzeService';

jest.mock('../axios-client');

describe('Testing IntolleranzeService', () => {

    it('Testing fetching allergeni',async () => {
        axiosClient.get.mockResolvedValueOnce({data:[]});
        const json = await fetchAllergeni();
        expect(Array.isArray(json)).toEqual(true)
        expect(json.length).toEqual(0)
    });
});