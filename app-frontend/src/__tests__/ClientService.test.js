import '@testing-library/jest-dom/extend-expect';
import axiosClient from '../axios-client';
import { fetchClientProfiles ,fetchClientProfile ,deleteClientProfile ,updateClientProfile } from '../services/ClientService';

jest.mock('../axios-client');

describe('Testing ClientService', () => {

    it('Testing fetching clients',async () => {
        axiosClient.get.mockResolvedValueOnce({data:[]});
        const json = await fetchClientProfiles();
        expect(Array.isArray(json)).toEqual(true)
        expect(json.length).toEqual(0)
    });

    it('Testing fetching single client',async () => {
        axiosClient.get.mockResolvedValueOnce({data:[]});
        const json = await fetchClientProfile();
        expect(Array.isArray(json)).toEqual(true)
        expect(json.length).toEqual(0)
    });

    it('Testing updating client',async () => {
        axiosClient.put.mockResolvedValueOnce({data:[]});
        const json = await updateClientProfile({});
        expect(Array.isArray(json)).toEqual(true)
        expect(json.length).toEqual(0)
    });

    it('Testing deleting client',async () => {
        axiosClient.delete.mockResolvedValueOnce({data:[]});
        const json = await deleteClientProfile({});
        expect(Array.isArray(json)).toEqual(true)
        expect(json.length).toEqual(0)
    });
});