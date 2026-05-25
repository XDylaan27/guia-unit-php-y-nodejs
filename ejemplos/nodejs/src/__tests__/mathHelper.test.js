const { add, divide } = require('../mathHelper');

describe('mathHelper', () => {

  // describe() agrupa tests relacionados
  describe('add()', () => {
    it('suma dos números positivos correctamente', () => {
      // Arrange
      const a = 2, b = 3;

      // Act
      const result = add(a, b);

      // Assert
      expect(result).toBe(5);
    });

    it('suma números negativos', () => {
      expect(add(-1, -4)).toBe(-5);
    });
  });

  describe('divide()', () => {
    it('devuelve el cociente correcto', () => {
      expect(divide(10, 4)).toBe(2.5);
    });

    it('lanza error al dividir entre cero', () => {
      expect(() => divide(5, 0)).toThrow('No se puede dividir entre cero.');
    });
  });

});