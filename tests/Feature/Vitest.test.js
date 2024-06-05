import { expect, describe, it } from 'vitest'
import { mount } from '@vue/test-utils';
import Map from '@/Components/Map.vue';
import L from 'leaflet';

describe('Map', () => {
  it('renderitza els mapes amb restaurants', () => {
    const restaurants = [
      {
        id: 1,
        name: 'Restaurant A',
        description: 'Description A',
        lat: 123,
        lng: 456,
        comments_avg_rating: 4.5
      },
      {
        id: 2,
        name: 'Restaurant B',
        description: 'Description B',
        lat: 789,
        lng: 101,
        comments_avg_rating: 3.0
      }
    ];

    const wrapper = mount(Map, {
      props: { restaurants }
    });

    expect(wrapper.vm.map).toBeDefined();

    const markers = wrapper.vm.markerGroup.getLayers();
    expect(markers).toHaveLength(restaurants.length);

    markers.forEach((marker, index) => {
      const restaurant = restaurants[index];
      expect(marker.getPopup().getContent()).toContain(restaurant.name);
      expect(marker.getPopup().getContent()).toContain(restaurant.description);
    });
  });
});
