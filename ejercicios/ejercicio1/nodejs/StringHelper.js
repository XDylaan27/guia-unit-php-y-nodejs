class StringHelper {
  static truncate(text, maxLength, suffix = "...") {
    if (maxLength <= 0) {
      throw new Error("El maxLength debe ser mayor a 0");
    }
    if (text.length <= maxLength) {
      return text;
    }
    return text.substring(0, maxLength) + suffix;
  }

  static toSlug(text) {
    return text
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '') 
      .trim()
      .replace(/\s+/g, '-'); 
  }

  static countWords(text) {
    if (!text || text.trim() === '') {
      return 0;
    }
    return text.trim().split(/\s+/).length;
  }
}

module.exports = StringHelper;