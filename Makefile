info:
	@echo "Usage: make install|test|debug"

# pass any target to composer
$(MAKECMDGOALS):
	composer $(MAKECMDGOALS)
